<?php

namespace App\Http\Controllers\ResourceTable;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResourceWrite extends Controller
{
    public function upload(Request $request)
    {
        try {

            /*
             * ============================================
             * Get request data
             * ============================================
             */

            $file =
                $request->file('file');

            $chunkIndex =
                (int) $request->input('chunkIndex');

            $totalChunks =
                (int) $request->input('totalChunks');

            $originalFileName =
                $request->input('originalFileName');

            $uploadId =
                $request->input('uploadId');

            $title =
                $request->input('title')
                ?: $originalFileName;

            $ownerRowId =
                $request->input('owner_row_id');

            $ownerTable =
                $request->input('owner_table');


            /*
             * ============================================
             * Validate uploaded file
             * ============================================
             */

            if (!$file) {

                return response()->json([
                    'error' => 'Missing file'
                ], 400);
            }


            /*
             * Check PHP/Laravel upload error.
             */

            if (!$file->isValid()) {

                return response()->json([
                    'error' =>
                    'Uploaded file is invalid: ' .
                        $file->getErrorMessage()
                ], 400);
            }


            if (!$originalFileName) {

                return response()->json([
                    'error' => 'Missing file name'
                ], 400);
            }


            if (!$uploadId) {

                return response()->json([
                    'error' => 'Missing upload ID'
                ], 400);
            }


            if ($totalChunks < 1) {

                return response()->json([
                    'error' => 'Invalid totalChunks'
                ], 400);
            }


            if (
                $chunkIndex < 0 ||
                $chunkIndex >= $totalChunks
            ) {

                return response()->json([
                    'error' => 'Invalid chunk index'
                ], 400);
            }


            /*
             * Upload ID must contain only
             * letters and numbers.
             */

            if (
                !preg_match(
                    '/^[A-Za-z0-9]+$/',
                    $uploadId
                )
            ) {

                return response()->json([
                    'error' => 'Invalid upload ID'
                ], 400);
            }


            /*
             * ============================================
             * Validate owner
             * ============================================
             *
             * Both can be NULL.
             *
             * If one is supplied, both are required.
             */

            $ownerTables = [

                'announcements' =>
                'announcement_id',

                'lecture_states' =>
                'lecture_state_id',

                'teachers' => 'teacher_id'

            ];


            if (
                $ownerRowId === null &&
                $ownerTable === null
            ) {

                /*
                 * Resource is standalone.
                 */
            } elseif (
                $ownerRowId === null ||
                $ownerTable === null
            ) {

                return response()->json([
                    'error' =>
                    'owner_row_id and owner_table must both be provided.'
                ], 400);
            } elseif (
                !array_key_exists(
                    $ownerTable,
                    $ownerTables
                )
            ) {

                return response()->json([
                    'error' =>
                    'Invalid owner table.'
                ], 400);
            } else {

                /*
                 * Get the primary key belonging
                 * to the selected table.
                 */

                $primaryKey =
                    $ownerTables[$ownerTable];


                /*
                 * Check that the referenced row
                 * actually exists.
                 */

                $exists =
                    DB::table($ownerTable)
                    ->where(
                        $primaryKey,
                        $ownerRowId
                    )
                    ->exists();


                if (!$exists) {

                    return response()->json([
                        'error' =>
                        'The specified owner does not exist.'
                    ], 404);
                }
            }


            /*
             * ============================================
             * Temporary chunk directory
             * ============================================
             */

            $tempFolder =
                storage_path(
                    'app/chunks/' . $uploadId
                );


            if (!is_dir($tempFolder)) {

                if (
                    !mkdir(
                        $tempFolder,
                        0777,
                        true
                    ) &&
                    !is_dir($tempFolder)
                ) {

                    throw new \Exception(
                        'Could not create temporary upload directory.'
                    );
                }
            }


            /*
             * ============================================
             * Save current chunk
             * ============================================
             */

            $chunkPath =
                $tempFolder .
                '/' .
                $chunkIndex;


            /*
             * Laravel moves the PHP temporary
             * uploaded file into our chunk directory.
             */

            if (
                !$file->move(
                    $tempFolder,
                    (string) $chunkIndex
                )
            ) {

                throw new \Exception(
                    "Could not save chunk {$chunkIndex}."
                );
            }


            /*
             * ============================================
             * Check whether all chunks arrived
             * ============================================
             */

            for (
                $i = 0;
                $i < $totalChunks;
                $i++
            ) {

                if (
                    !file_exists(
                        $tempFolder . '/' . $i
                    )
                ) {

                    return response()->json([

                        'message' =>
                        "Chunk {$chunkIndex} uploaded",

                        'uploadId' =>
                        $uploadId,

                        'chunkIndex' =>
                        $chunkIndex,

                        'totalChunks' =>
                        $totalChunks

                    ]);
                }
            }


            /*
             * ============================================
             * All chunks received
             * ============================================
             */


            /*
             * Get extension from original filename.
             *
             * The original filename is NEVER used
             * as the actual public filename.
             */

            $extension =
                strtolower(
                    pathinfo(
                        $originalFileName,
                        PATHINFO_EXTENSION
                    )
                );


            /*
             * Generate random public file ID.
             *
             * Example:
             *
             * a8K29xPq71Lm4Nz
             */

            $fileId =
                Str::random(16);


            /*
             * Final filename.
             */

            $finalFileName =
                $fileId;


            if ($extension !== '') {

                $finalFileName .=
                    '.' . $extension;
            }


            /*
             * ============================================
             * Temporary merged file
             * ============================================
             *
             * First merge into a temporary file.
             *
             * This allows us to detect the MIME type
             * from the COMPLETE file.
             */

            $mergedPath =
                storage_path(
                    'app/chunks/' .
                        $uploadId .
                        '_merged'
                );


            $output =
                fopen(
                    $mergedPath,
                    'wb'
                );


            if (!$output) {

                throw new \Exception(
                    'Could not create merged file.'
                );
            }


            /*
             * ============================================
             * Merge chunks
             * ============================================
             */

            for (
                $i = 0;
                $i < $totalChunks;
                $i++
            ) {

                $chunkPath =
                    $tempFolder .
                    '/' .
                    $i;


                if (!file_exists($chunkPath)) {

                    fclose($output);

                    throw new \Exception(
                        "Chunk {$i} disappeared during merge."
                    );
                }


                $input =
                    fopen(
                        $chunkPath,
                        'rb'
                    );


                if (!$input) {

                    fclose($output);

                    throw new \Exception(
                        "Could not open chunk {$i}."
                    );
                }


                while (!feof($input)) {

                    $data =
                        fread(
                            $input,
                            1024 * 1024
                        );


                    if ($data === false) {

                        fclose($input);
                        fclose($output);

                        throw new \Exception(
                            "Could not read chunk {$i}."
                        );
                    }


                    if ($data !== '') {

                        $written =
                            fwrite(
                                $output,
                                $data
                            );


                        if (
                            $written === false ||
                            $written < strlen($data)
                        ) {

                            fclose($input);
                            fclose($output);

                            throw new \Exception(
                                "Could not write merged file."
                            );
                        }
                    }
                }


                fclose($input);
            }


            fclose($output);


            /*
             * ============================================
             * Detect MIME from COMPLETE file
             * ============================================
             */

            $finfo =
                new \finfo(
                    FILEINFO_MIME_TYPE
                );


            $mimeType =
                $finfo->file(
                    $mergedPath
                );


            if (!$mimeType) {

                $mimeType =
                    'application/octet-stream';
            }


            /*
             * Convert MIME type into a safe folder name.
             *
             * image/jpeg
             * becomes
             * image_jpeg
             *
             * application/pdf
             * becomes
             * application_pdf
             */

            $mimeFolder =
                preg_replace(
                    '/[^A-Za-z0-9_-]/',
                    '_',
                    $mimeType
                );


            /*
             * ============================================
             * Create final public directory
             * ============================================
             */

            $filesFolder =
                public_path(
                    'englishdepartment/' .
                        $mimeFolder
                );


            if (!is_dir($filesFolder)) {

                if (
                    !mkdir(
                        $filesFolder,
                        0777,
                        true
                    ) &&
                    !is_dir($filesFolder)
                ) {

                    throw new \Exception(
                        'Could not create public file directory.'
                    );
                }
            }


            /*
             * ============================================
             * Final file path
             * ============================================
             */

            $finalFilePath =
                $filesFolder .
                '/' .
                $finalFileName;


            /*
             * Move the merged file to its
             * final public location.
             */

            if (
                !rename(
                    $mergedPath,
                    $finalFilePath
                )
            ) {

                /*
                 * Fallback for systems where rename()
                 * cannot move between filesystems.
                 */

                if (
                    !copy(
                        $mergedPath,
                        $finalFilePath
                    )
                ) {

                    throw new \Exception(
                        'Could not move merged file to final location.'
                    );
                }


                unlink($mergedPath);
            }


            /*
             * ============================================
             * Delete chunks
             * ============================================
             */

            for (
                $i = 0;
                $i < $totalChunks;
                $i++
            ) {

                $chunkPath =
                    $tempFolder .
                    '/' .
                    $i;


                if (
                    file_exists(
                        $chunkPath
                    )
                ) {

                    unlink($chunkPath);
                }
            }


            /*
             * Remove temporary directory.
             */

            if (
                is_dir(
                    $tempFolder
                )
            ) {

                rmdir(
                    $tempFolder
                );
            }


            /*
             * ============================================
             * Generate public URL
             * ============================================
             */

            $fileUrl = '/' .
                'englishdepartment/' .
                $mimeFolder .
                '/' .
                $finalFileName;


            /*
             * ============================================
             * Create Resource database row
             * ============================================
             */

            $resource =
                Resource::create([

                    'owner_row_id' =>
                    $ownerRowId,

                    'owner_table' =>
                    $ownerTable,

                    'title' =>
                    $title,

                    'url' =>
                    $fileUrl

                ]);


            /*
             * ============================================
             * Return result
             * ============================================
             */

            return response()->json([

                'message' =>
                'Resource uploaded successfully',

                'resource_id' =>
                $resource->resource_id,

                'title' =>
                $resource->title,

                'url' => $fileUrl

            ]);
        } catch (\Exception $e) {

            Log::error(
                'Resource upload error: ' .
                    $e->getMessage(),
                [
                    'upload_id' =>
                    $request->input('uploadId'),

                    'chunk_index' =>
                    $request->input('chunkIndex'),

                    'total_chunks' =>
                    $request->input('totalChunks')
                ]
            );


            return response()->json([

                'error' =>
                $e->getMessage()

            ], 500);
        }
    }
}
