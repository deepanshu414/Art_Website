<div align="center">
      <img src="https://socialify.git.ci/deepanshu414/Art_Website/image?forks=1&issues=1&name=1&pattern=Floating%20Cogs&pulls=1&stargazers=1&theme=Auto" alt="artwebsite" width="640" height="320" />
   </div>

`Art Store` is an online platform built with PHP, where users can showcase their artwork, explore art from other creators, and purchase unique pieces. It allows artists to store and display their creations while providing art lovers a marketplace to discover and buy art.

## Table of Contents
- [Features](#features)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Usage](#usage)
- [File Structure](#file-structure)
- [Contributing](#contributing)
- [License](#license)
- [Support](#support)

## Features

- **User Authentication :** Users must log in to access the platform. No one can enter without logging in.
- **Store Art :** Artists can upload their artwork along with additional information that other users can view.
- **View Art :** Users can browse artwork uploaded by others.
- **Purchase Art :** Users can purchase artwork using their mobile number.
- **Database Storage :** All information, including images, is stored in the database.

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server
- XAMPP (for local development)

## Installation

1. **Clone the repository**<br>
   To clone the repository, run the following command in your terminal or command prompt:
```sh
git clone https://github.com/deepanshu414/Art_Website.git
```
2. **Navigate to the project directory**
```sh
cd Art_Website
```
3. **Set up the database**
- Adjust the `db_connect.php` file according to your database settings. Update the database host, username, password, and database name.
- To set up the database structure, navigate to the `database_structure.txt` file. This file contains the SQL queries required to create the necessary tables and fields in your database. You can copy the query and execute it in your database management tool (e.g. MySQL Workbench, etc.).

4. **Run the Application Using XAMPP**
  - Download and install [XAMPP](https://www.apachefriends.org/download.html) if you don't have it installed on your machine.
  - Place the cloned repository folder (`Art_Website`) into your `htdocs` folder. The default location of the `htdocs` folder is typically:
    - **Windows: `C:\xampp\htdocs\`**
    - **macOS/Linux: `/opt/lampp/htdocs/`**
  - Start the Apache and MySQL services from the XAMPP Control Panel.
  - Open your browser and navigate to `http://localhost/Art_Website` to access the application.

5. **Configure the database connection**
- **Database Connection :** Make sure to adjust the `db_connect.php` file . Set your database host, username, password, and database name like this:
  ```php
  $host = "localhost";    
  $username = "root";     
  $password = "your_password";        
  $database = "artstore"; 
  ```
- **Database Structure :** Ensure your database structure matches the one provided in `database_structure.txt`. Execute the SQL query in your database management system to create the necessary tables and fields.


6. **Access the website**
- Open a web browser and navigate to `http://localhost/Art_Website`

## Usage

- After setting up the database and running the application through XAMPP, users can:
  - **Register and log** in to their accounts.
  - **Upload artwork** by providing necessary information such as title, description, and image file.
  - **Browse and purchase art** using their mobile number.

## File Structure

- `index.php`: Home page
- `login.php`: User login page
- `upload.php`: Artwork upload page
- `gallery.php`: Artwork browsing page
- `contact.php`: Artwork contact page
- `db_connect.php`: Database connection configuration
- `uploads/`: Directory for storing uploaded artwork

## Contributing

1. Fork the repository
2. Create a new branch: `git checkout -b feature-name`
3. Make your changes and commit them: `git commit -m 'Add some feature'`
4. Push to the branch: `git push origin feature-name`
5. Submit a pull request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

If you encounter any issues or have questions, please open an issue in the GitHub repository.
