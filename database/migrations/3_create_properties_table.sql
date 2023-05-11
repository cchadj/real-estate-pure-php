SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS real_estate.properties;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE IF NOT EXISTS real_estate.properties (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) UNIQUE,
    description TEXT,
    price DECIMAL(10, 2),
    publication_date DATE,
    property_type_id INT,
    area_id INT,
    city_id INT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    FOREIGN KEY (area_id) REFERENCES real_estate.areas (id)
       ON DELETE SET NULL
       ON UPDATE CASCADE,
    FOREIGN KEY (property_type_id) REFERENCES real_estate.property_types (id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);
