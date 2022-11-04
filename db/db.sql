PRAGMA foreign_keys=OFF;

BEGIN TRANSACTION;

CREATE TABLE users (
    uid GUID PRIMARY KEY,
    email TEXT,
    username TEXT,
    password HASH
);

CREATE TABLE user_works (
    uid GUID,
    title TEXT,
    tags JSON,
    body BLOB,
    type PUBLISH_STATUS,
    published_date DATETIME,

    FOREIGN KEY (uid) REFERENCES users(uid)
    ON DELETE CASCADE
);

COMMIT;
