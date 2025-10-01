<h1 align="center">🛍️ Kermit Store</h1>

<p align="center">
  A lightweight eCommerce prototype built with <b>PHP 8.3</b> and <b>MySQL 8</b>, 
  developed without frameworks to demonstrate core technical skills.
</p>

<p align="center">
  <img src="screenshot.gif" alt="Kermit Store Screenshot" width="600">
</p>

---

## 📖 About the Project
Kermit Store is a simplified eCommerce system that implements the main shopping flow 
(browsing, adding items to cart, checkout) **without a payment module**.  

The main goal of the project is to demonstrate:
- Strong **vanilla PHP** development skills.
- Ability to design and implement a **custom routing system**.
- Session handling and state management without external libraries.
- Clean architecture and maintainable code structure.

---

## 🛠️ Tech Stack
- **Language:** PHP 8.3
- **Database:** MySQL 8
- **Frontend:** HTML5, CSS3, Vanilla JS
- **Architecture:** Custom routing + MVC-inspired structure
- **No frameworks** – everything built from scratch

---

## ✨ Features
- 🔗 Custom routing system to load pages dynamically.  
- 🛒 Shopping cart and checkout flow (no payment).  
- 🔑 Session-based user management.  
- 📦 Product browsing and adding to cart.  
- ⚡ Lightweight and fast, built for demonstration purposes.  

---

## ✅ Requirements
To run this system, you will need:
- Webserver (Apache/Nginx/…)  
- PHP 8.3  
- MySQL 8  

---

## 🚀 How to Run the System

1. **Configure the webserver** to point to the root of this project (where the `index.php` file is located).  
2. **Enable the rewrite module** on your server so that the `.htaccess` file can overwrite the settings.  
3. **Create the database**:  
   - You can use the MySQL Workbench file (`/doc/database.mwb`).  
   - Or use the ready-to-import SQL file (`/doc/SQL Files/database.sql`).  
4. **Adjust the database settings** in:  
   \```bash
   app/Library/db_conection.php
   \```
5. **Open the browser** and access the URL you configured for the project.  

---

## 📂 Project Structure

```
.
├── app
│   ├── Library
│   │   └── db_conection.php        # Database connection handler
│   ├── pages                       # Main application pages
│   │   ├── about.php
│   │   ├── components              # Reusable UI components
│   │   │   ├── footer.php
│   │   │   ├── header.php
│   │   │   └── navbar.php
│   │   ├── contact.php
│   │   ├── create.php
│   │   ├── home.php
│   │   ├── login.php
│   │   ├── models
│   │   │   └── product.php         # Product model
│   │   ├── orders.php
│   │   ├── payment.php
│   │   ├── shipping.php
│   │   ├── shoppingCart.php
│   │   └── system
│   │       ├── 404.php             # Error page
│   │       └── dbError.php         # DB error handling
│   └── route.php                   # Custom routing system
│
├── assets
│   ├── css
│   │   └── style.css
│   ├── images                      # Project images and illustrations
│   └── javascript
│       └── app.js
│
├── doc
│   ├── database.mwb                # MySQL Workbench model
│   ├── database.mwb.bak
│   ├── DB.png
│   ├── products.sql
│   └── SQL Files
│       └── database.sql
│
├── favicon.ico
├── index.php                       # Entry point
├── README.md
└── screenshot.gif
```
