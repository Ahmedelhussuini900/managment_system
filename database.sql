CREATE DATABASE management_system;

USE management_system;

CREATE TABLE departments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        department_name VARCHAR(255) NOT NULL,
         location VARCHAR(255) NOT NULL
     );



     CREATE TABLE employees (
         id INT AUTO_INCREMENT PRIMARY KEY,
         first_name VARCHAR(255) NOT NULL,
         last_name VARCHAR(255) NOT NULL,
         email VARCHAR(255) UNIQUE NOT NULL,
         hire_date DATE NOT NULL,
         salary FLOAT NOT NULL,
         department_id INT NOT NULL,
         job_title VARCHAR(255) NOT NULL,
        FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE);




        CREATE TABLE performance_reviews (
         id INT AUTO_INCREMENT PRIMARY KEY,
         employee_id INT NOT NULL,
         review_text TEXT NOT NULL,
         review_date DATE NOT NULL,
         FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
    );


