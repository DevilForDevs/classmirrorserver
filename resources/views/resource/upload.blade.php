<div class="resource-uploader">

    <h3>Attach Resource</h3>

    {{-- ================================
         Owner Table
         ================================= --}}
    <div class="form-group">

        <label for="resourceOwnerTable">
            Owner Table
        </label>

        <select
            id="resourceOwnerTable"
            class="resource-input">

            <option value="">
                None / Standalone Resource
            </option>

            <option value="announcements">
                Announcements
            </option>

            <option value="lecture_states">
                Lecture States
            </option>

            <option value="assignments">
                Assignments
            </option>

            <option value="teachers">
                Teachers
            </option>

        </select>

        <small>
            Select the table this resource belongs to,
            or leave it empty for a standalone resource.
        </small>

    </div>


    {{-- ================================
         Owner Row ID
         ================================= --}}
    <div class="form-group">

        <label for="resourceOwnerRowId">
            Owner Row ID
        </label>

        <input
            type="number"
            id="resourceOwnerRowId"
            class="resource-input"
            placeholder="Example: 25"
            min="1">

        <small>
            Required when an Owner Table is selected.
        </small>

    </div>


    {{-- ================================
         Title
         ================================= --}}
    <div class="form-group">

        <label for="resourceTitle">
            Title
        </label>

        <input
            type="text"
            id="resourceTitle"
            class="resource-input"
            placeholder="Resource title">

    </div>


    {{-- ================================
         File
         ================================= --}}
    <div class="form-group">

        <label for="resourceFile">
            Select File
        </label>

        <input
            type="file"
            id="resourceFile"
            class="resource-input"
            accept="*/*">

    </div>


    {{-- ================================
         Upload button
         ================================= --}}
    <button
        type="button"
        id="resourceUploadButton">

        Upload Resource

    </button>


    {{-- ================================
         Status
         ================================= --}}
    <div
        id="resourceStatus"
        style="
            margin-top: 15px;
            padding: 10px;
            display: none;
        ">
    </div>


    {{-- ================================
         Progress
         ================================= --}}
    <progress
        id="resourceProgress"
        value="0"
        max="100"
        style="
            width: 100%;
            margin-top: 10px;
            display: none;
        ">
    </progress>


    {{-- ================================
         Result
         ================================= --}}
    <div
        id="resourceResult"
        style="margin-top: 15px;">
    </div>

</div>


<style>
    .resource-uploader {
        max-width: 650px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .resource-uploader h3 {
        margin-top: 0;
        margin-bottom: 20px;
    }

    .resource-uploader .form-group {
        margin-bottom: 16px;
    }

    .resource-uploader label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .resource-uploader small {
        display: block;
        margin-top: 5px;
        color: #666;
    }

    .resource-input {
        width: 100%;
        padding: 9px;
        box-sizing: border-box;
    }

    #resourceUploadButton {
        padding: 10px 18px;
        cursor: pointer;
    }

    #resourceUploadButton:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }

    #resourceStatus.success {
        border: 1px solid #198754;
    }

    #resourceStatus.error {
        border: 1px solid #dc3545;
    }

    .resource-error {
        color: #dc3545;
    }

    .resource-success {
        color: #198754;
    }

    .resource-error-details {
        margin-top: 8px;
        padding: 10px;
        background: #f8f8f8;
        border: 1px solid #ddd;
        white-space: pre-wrap;
        word-break: break-word;
    }
</style>


<script>
    (function() {

        const ownerTableInput =
            document.getElementById(
                'resourceOwnerTable'
            );

        const ownerRowIdInput =
            document.getElementById(
                'resourceOwnerRowId'
            );

        const fileInput =
            document.getElementById(
                'resourceFile'
            );

        const titleInput =
            document.getElementById(
                'resourceTitle'
            );

        const uploadButton =
            document.getElementById(
                'resourceUploadButton'
            );

        const status =
            document.getElementById(
                'resourceStatus'
            );

        const progress =
            document.getElementById(
                'resourceProgress'
            );

        const result =
            document.getElementById(
                'resourceResult'
            );


        const CHUNK_SIZE =
            8 * 1024 * 1024;


        /*
         * ============================================
         * Enable/disable Owner Row ID
         * ============================================
         */

        ownerTableInput.addEventListener(
            'change',
            function() {

                if (this.value === '') {

                    ownerRowIdInput.value = '';

                    ownerRowIdInput.disabled = true;

                } else {

                    ownerRowIdInput.disabled = false;

                }

            }
        );


        /*
         * Initially standalone
         */

        ownerRowIdInput.disabled = true;


        /*
         * ============================================
         * Upload
         * ============================================
         */

        uploadButton.addEventListener(
            'click',
            async function() {

                clearMessages();


                const file =
                    fileInput.files[0];


                /*
                 * ========================================
                 * Client-side validation
                 * ========================================
                 */

                if (!file) {

                    showError(
                        'Please select a file.'
                    );

                    return;
                }


                const ownerTable =
                    ownerTableInput.value.trim();


                const ownerRowId =
                    ownerRowIdInput.value.trim();


                if (
                    ownerTable !== '' &&
                    ownerRowId === ''
                ) {

                    showError(
                        'Owner Row ID is required when an Owner Table is selected.'
                    );

                    ownerRowIdInput.focus();

                    return;
                }


                if (
                    ownerTable === '' &&
                    ownerRowId !== ''
                ) {

                    showError(
                        'Owner Table is required when an Owner Row ID is provided.'
                    );

                    ownerTableInput.focus();

                    return;
                }


                const title =
                    titleInput.value.trim() ||
                    file.name;


                /*
                 * ========================================
                 * Generate upload ID
                 * ========================================
                 */

                const uploadId =
                    crypto
                    .randomUUID()
                    .replace(/-/g, '');


                uploadButton.disabled = true;

                progress.style.display =
                    'block';

                progress.value = 0;


                try {

                    /*
                     * ====================================
                     * Calculate chunks
                     * ====================================
                     */

                    const totalChunks =
                        Math.ceil(
                            file.size /
                            CHUNK_SIZE
                        );


                    /*
                     * ====================================
                     * Upload chunks
                     * ====================================
                     */

                    for (
                        let chunkIndex = 0; chunkIndex < totalChunks; chunkIndex++
                    ) {

                        const start =
                            chunkIndex *
                            CHUNK_SIZE;


                        const end =
                            Math.min(
                                start +
                                CHUNK_SIZE,
                                file.size
                            );


                        const chunk =
                            file.slice(
                                start,
                                end
                            );


                        const formData =
                            new FormData();


                        formData.append(
                            'file',
                            chunk,
                            file.name
                        );


                        formData.append(
                            'originalFileName',
                            file.name
                        );


                        formData.append(
                            'title',
                            title
                        );


                        formData.append(
                            'chunkIndex',
                            chunkIndex
                        );


                        formData.append(
                            'totalChunks',
                            totalChunks
                        );


                        formData.append(
                            'uploadId',
                            uploadId
                        );


                        /*
                         * Only send owner fields when
                         * they actually have values.
                         */

                        if (ownerTable !== '') {

                            formData.append(
                                'owner_table',
                                ownerTable
                            );

                        }


                        if (ownerRowId !== '') {

                            formData.append(
                                'owner_row_id',
                                ownerRowId
                            );

                        }


                        showStatus(
                            `Uploading chunk ${chunkIndex + 1} of ${totalChunks}...`
                        );


                        /*
                         * ==================================
                         * Send request
                         * ==================================
                         */

                        let response;


                        try {

                            response =
                                await fetch(
                                    "{{ route('resource.upload') }}", {
                                        method: 'POST',

                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',

                                            'Accept': 'application/json'
                                        },

                                        body: formData
                                    }
                                );

                        } catch (networkError) {

                            throw new Error(
                                'Network error. Could not connect to the server.'
                            );

                        }


                        /*
                         * ==================================
                         * Read response safely
                         * ==================================
                         */

                        let data;


                        try {

                            data =
                                await response.json();

                        } catch (jsonError) {

                            throw new Error(
                                `Server returned an invalid response (HTTP ${response.status}).`
                            );

                        }


                        /*
                         * ==================================
                         * Handle PHP/Laravel error
                         * ==================================
                         */

                        if (!response.ok) {

                            let errorMessage =
                                data.error ||
                                data.message ||
                                `Upload failed with HTTP ${response.status}.`;


                            /*
                             * Laravel validation errors
                             */

                            if (
                                data.errors &&
                                typeof data.errors === 'object'
                            ) {

                                const validationMessages = [];


                                Object.keys(
                                    data.errors
                                ).forEach(
                                    function(field) {

                                        const messages =
                                            data.errors[field];

                                        if (
                                            Array.isArray(
                                                messages
                                            )
                                        ) {

                                            messages.forEach(
                                                function(message) {

                                                    validationMessages.push(
                                                        message
                                                    );

                                                }
                                            );

                                        }

                                    }
                                );


                                if (
                                    validationMessages.length > 0
                                ) {

                                    errorMessage =
                                        validationMessages.join(
                                            '\n'
                                        );

                                }

                            }


                            throw new Error(
                                errorMessage
                            );

                        }


                        /*
                         * ==================================
                         * Progress
                         * ==================================
                         */

                        const percent =
                            (
                                (chunkIndex + 1) /
                                totalChunks
                            ) * 100;


                        progress.value =
                            percent;


                        /*
                         * ==================================
                         * Final response
                         * ==================================
                         */

                        if (
                            data.resource_id
                        ) {

                            showSuccess(
                                'Resource uploaded successfully.'
                            );
                            console.log(data.url);


                            result.innerHTML = `
                            <div class="resource-success">

                                <strong>
                                    Resource created
                                </strong>

                                <br><br>

                                Resource ID:
                                ${escapeHtml(
                                    String(
                                        data.resource_id
                                    )
                                )}

                                <br>

                                Title:
                                ${escapeHtml(
                                    data.title
                                )}

                                <br>

                                URL:
                                <a
                                    href="${escapeHtml(
                                        data.url
                                    )}"
                                    target="_blank"
                                    rel="noopener"
                                >
                                    Open Resource
                                </a>

                            </div>
                        `

                            fileInput.value = '';
                            titleInput.value = '';

                            ownerTableInput.value = '';
                            ownerRowIdInput.value = '';
                            ownerRowIdInput.disabled = true;

                            progress.value = 0;
                            progress.style.display = 'none';

                            ;

                        } else {

                            showStatus(
                                `Uploaded chunk ${chunkIndex + 1} of ${totalChunks} (${Math.round(percent)}%)`
                            );

                        }

                    }


                    progress.value = 100;


                } catch (error) {

                    console.error(
                        'Resource upload error:',
                        error
                    );


                    showError(
                        error.message ||
                        'Unknown upload error.'
                    );


                    /*
                     * Show upload ID so a server-side log
                     * can be correlated with this failure.
                     */

                    result.innerHTML = `
                    <div class="resource-error-details">

                        <strong>
                            Upload failed
                        </strong>

                        <br><br>

                        Upload ID:
                        ${escapeHtml(
                            uploadId
                        )}

                        <br><br>

                        Error:
                        ${escapeHtml(
                            error.message
                        )}

                    </div>
                `;

                } finally {

                    uploadButton.disabled =
                        false;


                }

            }
        );


        /*
         * ============================================
         * Status helpers
         * ============================================
         */

        function clearMessages() {

            status.style.display =
                'none';

            status.className = '';

            status.textContent =
                '';

            result.innerHTML =
                '';

            progress.value =
                0;

        }


        function showStatus(message) {

            status.style.display =
                'block';

            status.className =
                '';

            status.textContent =
                message;

        }


        function showSuccess(message) {

            status.style.display =
                'block';

            status.className =
                'success';

            status.textContent =
                message;

        }


        function showError(message) {

            status.style.display =
                'block';

            status.className =
                'error';

            status.textContent =
                message;

        }


        /*
         * ============================================
         * HTML escaping
         * ============================================
         */

        function escapeHtml(value) {

            const div =
                document.createElement(
                    'div'
                );

            div.textContent =
                value ?? '';

            return div.innerHTML;

        }

    })();
</script>