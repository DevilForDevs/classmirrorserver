
CREATE TABLE syllabus (
    topic_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    topic VARCHAR(255) NOT NULL,
    total_lectures INT UNSIGNED NOT NULL DEFAULT 0,
    author VARCHAR(255),
    description TEXT
);

INSERT INTO syllabus
(topic, total_lectures, author, description)
VALUES
(
    'Romantic Poetry',
    8,
    'William Wordsworth',
    'Study of major themes and poems of Romantic poetry.'
);

CREATE TABLE lectures (
    lecture_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    topic_id INT UNSIGNED NOT NULL,
    started_at DATETIME NULL,
    ended_at DATETIME NULL,
    teacher_name VARCHAR(255) NOT NULL,
    status ENUM('activity', 'complete', 'broken', 'cancelled') NOT NULL DEFAULT 'activity',
    description TEXT,
    
    FOREIGN KEY (topic_id)
        REFERENCES syllabus(topic_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);