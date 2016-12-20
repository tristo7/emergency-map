## TEST
# emergency-map
[View the map here.](http://tristo7.asuscomm.com/emergency-map/EmergencyAreaClient.html)


[Administrate the map here.](http://tristo7.asuscomm.com/emergency-map/EmergencyAreaAdmin.html)

Uses:
- mySQL
- php
- JavaScript
- HTML5

mySQL Schema:
- emergencyarea
	- Tables
		- data 
			- ID 
				- auto increment
				- primary key
			- latLNgArray
				- longtext
			- expiration
				- datetime
			- description
				- longtext
			- type
				- varchar(64)
			- Foreign Key
				- type references TypeName from types table
		- login
			- LoginID 
				- auto increment
				- primary key
			- Username
				- VARCHAR(16)
			- PasswordHash
				- VARCHAR(32)
			- PasswordSalt
				- int(11)
		- types
			- Color
				- VARCHAR(6)
					- This is the hex value of a color, such as ffffff.
			- TypeName
				- primary key
				- defaults to 'other'