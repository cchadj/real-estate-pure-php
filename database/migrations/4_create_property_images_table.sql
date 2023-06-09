SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS property_images;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE IF NOT EXISTS property_images (
    id INT NOT NULL AUTO_INCREMENT,

    name VARCHAR(255),
    path VARCHAR(355),
    property_id INT,
    description TEXT DEFAULT (''),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    FOREIGN KEY (property_id) REFERENCES properties (id)
       ON DELETE CASCADE
       ON UPDATE CASCADE
);
