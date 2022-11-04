PRAGMA foreign_keys=OFF;

BEGIN TRANSACTION;

CREATE TABLE users (
    uid GUID PRIMARY KEY NOT NULL,
    email TEXT NOT NULL,
    username TEXT NOT NULL,
    password HASH NOT NULL
);

CREATE TABLE user_works (
    uid GUID NOT NULL,
    title TEXT NOT NULL,
    tags JSON,
    body BLOB,
    type PUBLISH_STATUS NOT NULL,
    published_date DATETIME NOT NULL,

    FOREIGN KEY (uid) REFERENCES users(uid)
    ON DELETE CASCADE
);

COMMIT;
