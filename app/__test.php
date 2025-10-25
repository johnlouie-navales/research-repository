<?php

// require autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// class imports
use App\Models\Author;
use App\Models\Department;
use App\Models\ResearchWork;

// tests
echo "<pre>";
echo "<h1>Authors</h1>";
print_r(Author::all());

echo "<pre>";
echo "<h1>Departments</h1>";
print_r(Department::all());

echo "<pre>";
echo "<h1>Research Works</h1>";
print_r(ResearchWork::all());