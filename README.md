# cosc349-A2
assignment 2 for cosc349

to view the application running on the cloud, follow this link:
http://ec2-3-234-240-215.compute-1.amazonaws.com/

(Valid as of Friday 8th October 2021)


To deploy the application to a set of new cloud instances, follow the steps below:

- Create the EC2 web server instance on the Amazon cloud
- Install apache onto the EC2
- Created the RDS MySQL database instance
- Configure the database using MySQL Workbench
- Configure security groups to allow RDS and EC2 to interact
- Connect the EC2 web server to the RDS
- Deploy the index.php file onto the EC2, change the relevant endpoint, name, username and password!
- Create S3 bucket
- Create IAM Role
- Add IAM Role to EC2 and S3 bucket

Interactions-
Both the RDS and the S3 bucket currently only interact with the EC2 instance.
    - the EC2 writes to and reads from the RDS, displaying the contents in a table
    - when the EC2 deletes from the RDS, the php script will extract the deleted value,
      encode it in a Json format, write that to a Json file and move the file into the S3 bucket

