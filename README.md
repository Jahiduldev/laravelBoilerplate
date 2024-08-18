#Instruction


#### Requirements:
- To complete the tasks outlined below, you will need:
- Proficiency in Laravel, MySQL, JavaScript and jQuery.
- Access to a hosting server for deployment or the ability to use a free hosting service like [InfinityFree](https://www.infinityfree.com/).


#### Task Overview:

This is an "Product Management System" developed using Laravel, MySQL, JavaScript and jQuery. The project requires complete to several modules. Firstly need to separate the layout for each type user (Admin, Vendor, Customer). Also, it needs to be made Category and Product Module. Here need to apply product and category many to many relations and product with features hasmany relation. . Here is an overview of the tasks to be completed and the issues that must be resolved.
#### Project Setup Instructions:

- Clone this repository form this url

```bash
git clone https://github.com/jugol-kumar/internship-test.git
```
- Setup your project with composer requirement. 
- Setup a database with your preferred name.
- Run php artisan migrate:fresh --seed command after setup Database.
```bash
php artisan migrate:fresh --seed
```


#### Task and Issues:

### Task 1: 
Setup the unique template layout for each type user. By default load here common layout. 


### Task 2:
Upload user profile picture using by jquery ajax request system. must be use another router and controller for these operations.


### Task 3:
Complete the category module that displays categories along with the count of products they contain. Ensure it's created by this uer and utilizes eager loading for efficiency. Each category may have multiple products associated with it. Implement pagination to manage the display of data for a smoother user experience.

### Task 4:
Develop a product module that retrieves all products along with their associated categories and product features. Each product may belong to multiple categories and have multiple features. Utilize eager loading to efficiently load categories and features for each product. Additionally, ensure that only products created by the authenticated user (where the creator ID matches the authenticated user's ID) are displayed. Implement pagination to manage the display of data for a smoother user experience.



#### Submission Process:
- Complete all task.
- Deploy the update project and share live url (not mandatory).
- Upload this project in GitHub and share repository link.


Thanks and regards, Best of luck.
