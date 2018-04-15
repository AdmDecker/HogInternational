hostname="localhost"
database_name="RidesDB"
username="RidesDBUser"
password="RidesDBPass"

echo "Deleting old database..."
mysql -e "DROP DATABASE $database_name"
echo "Creating User..."
mysql -e "CREATE USER $username IDENTIFIED BY '$password'"
echo "Creating database..."
mysql -e "CREATE DATABASE $database_name"
mysql  $database_name < createdb.sql
mysql -e "GRANT ALL PRIVILEGES ON $database_name.* TO $username"

echo "Writing WebStoryGen dbconf.ini..."
sed -i.bak s/HOSTNAME/$hostname/g dbconf.ini
sed -i.bak s/DATABASE_NAME/$database_name/g dbconf.ini
sed -i.bak s/USERNAME/$username/g dbconf.ini
sed -i.bak s/PASSWORD/$password/g dbconf.ini
rm dbconf.ini.bak
echo "Setup completed successfully! If dependencies are installed and Apache is properly configured, Rides should be ready to go."
