# YouCan Test Challenge 

**Project Description**: a simple laravel vue application Made By othman Charai.

## Local Installation and Setup

### Prerequisites

Before you begin, ensure you have met the following requirements:

- **PHP**: Ensure you have PHP 7.4 or higher installed on your local machine.

- **Node.js**: You should have Node.js version 16 or higher installed.

### Clone the Repository

```bash
git clone git@github.com:OthmanCharai/Youcan_Code_Challenge.git
```
### Go inside project
```bash
cd Youcan_Code_Challenge
```
### Copy .env.example to .env
```bash
cp .env.example .env
```
```bash 
1: Create a new databases in your apache server
2: Add your db credentials to .env
3: make sure FILESYSTEM_DRIVER=public, in your .env

```
```bash 
4:  php artisan storage:link 
```

```bash 
5:  php artisan migrate 
```

```bash 
6:  npm i
```

```bash 
7:  npm run watch
```
#### and here we go you are ready to go
## Features
- This is a laravel Vue js project
- Expose a Rest api using laravel
- Each Features (products,categories) should have a  route file under routes/api folder
- Using the Repository design pattern may seem like over-engineering for this small project, but it's a powerful approach that helps keep the code organized
- Handle Exception each exception has a code
- A simple test for store product
- php artisan product:create
  -- will allow you to create a new product via cli
- Vue 3 with setup script

