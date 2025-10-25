# Digital Research Repository: An Innovative System for Efficient Storage and Seamless Access to Research Works

> A Digital Research Repository built with PHP, MySQL, and a custom MVC framework. Designed for efficient storage and access to academic works.



## 📚 About This Project

This project is a web-based software application designed to serve as a centralized digital repository for academic research. The goal is to provide a system for the efficient storage of research works (like papers, theses, and studies) and to allow future researchers to seamlessly find and access related literature through advanced filtering and search capabilities.

This repository is built from scratch using a custom Model-View-Controller (MVC) architecture in PHP.

---

## ✨ Features

* **Secure Uploads:** Upload new research papers and documents.
* **Dynamic Search:** A fast, `FULLTEXT` search across titles, abstracts, and keywords.
* **Filtering & Sorting:** Filter research works by department or publication year.
* **Relationship Management:** Links papers to their respective authors and departments.
* **MVC Architecture:** Organized, scalable, and maintainable codebase.

---

## 💻 Tech Stack

* **Backend:** PHP 8.2
* **Database:** MySQL (using MariaDB 10.4)
* **Frontend:** HTML, CSS, JavaScript (with plans for Vue.js)
* **Architecture:** Custom-built MVC (Model-View-Controller)

---

## 🚀 Getting Started

To get a local copy up and running, follow these simple steps.

### Prerequisites

You will need a local server environment with PHP and MySQL.
* [XAMPP](https://www.apachefriends.org/) or any similar stack (WAMP, MAMP, LAMP).

### Installation

1.  **Clone the repo**
    ```sh
    git clone https://github.com/johnlouie-navales/research-repository.git
    ```

2.  **Navigate to the project directory**
    ```sh
    cd research-repository
    ```

3.  **Set up the Database**
    * Open your MySQL admin tool (e.g., phpMyAdmin).
    * Create a new database named `research-repository`.
    * Import the `.sql` file (you can add your exported SQL dump to the repo, maybe in a `/database` folder) to create all the tables.

4.  **Configure Database Connection**
    * In the `config/` directory, find the template file named `database.example.php`.
    * Create a copy of this file and rename the copy to `database.php`.
    * This new `database.php` file is already listed in `.gitignore`, so your credentials will remain private.
    * Open `database.php` and fill in your local database `username`, `password`, and `database` name.

5.  **Run the Application**
    * Point your local web server (Apache in XAMPP) to the project's root directory.
    * Open your browser and navigate to `http://localhost/research-repository`.

---

## 📜 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
