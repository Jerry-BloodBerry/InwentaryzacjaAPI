# InwentaryzacjaAPI
API for a mobile app student project. We are currently developing a 
mobile app for Android which will be used for stocktaking of assets 
belonging to our university (in theory). I thought of it as a great
opportunity to put my PHP skills to a test and create an API which
will enable us to query an external server's database for data.

The entire project is written in vanilla PHP.

## Endpoints
All the read and read_one endpoints are of type GET. 
All the create and delete endpoints are of type POST.
-----------------------------------------------------
### Login
* /login/login.php - creates session for a user that has an
account in the database. Returns a token allowing the user
to make requests listed below.
### Asset
* /asset/read_one.php?id=? - returns object of type Asset with
 the specified id along with its AssetType, Room and Building
 in JSON format.
* /asset/create.php - when passed complete data (type) it creates
 an Asset object and persists it in the database.
* /asset/delete.php - when passed the asset's id it deletes
  the Asset object from the database. If the asset does not exist
  in the database this will return an error 
  message in JSON format.
### AssetType
* /asset_type/read.php - returns all objects of type AssetType
 in JSON format.
* /asset_type/read_one.php?id=? - returns object of type AssetType
 with the specified id in JSON format.
* /asset_type/create.php - when passed complete data it creates
 an AssetType object and persists it in the database.
* /asset_type/delete.php - when passed the AssetType's id it
 deletes the AssetType object from the database. If the asset
 does not exist in the database this will return an error 
 message in JSON format.
 ### Building
 * /building/read.php - returns all objects of type Building in JSON
 format.
 * /building/read_one.php?id=? - returns object of type Building with
  the specified id in JSON format.
 * /building/create.php - when passed complete data it creates
  a Building object and persists it in the database.
 * /building/delete.php - when passed the asset's id it deletes
   the Building object from the database. If the building does not
   exist in the database this will return an error 
   message in JSON format.
 * /building/read_rooms.php - returns all objects of type 
   Room belonging to the building with the specified id in JSON format.
 ### Report
  * /report/read.php - returns all objects of type Report in JSON
  format.
  * /report/read_one.php?id=? - returns object of type Report with
   the specified id in JSON format.
  * /report/create.php - when passed complete data it creates
   a Report object and persists it in the database.
  * /report/delete.php - when passed the report's id it deletes
    the Report object from the database. If the report does not
    exist in the database this will return an error 
    message in JSON format.
  * /report/read_assets.php?id=? - returns all assets
    of type ReportAsset, that were inside the report with the given
    id, in JSON format
  ### Room
  * /room/create.php - when passed complete data it creates
  a Room object and persists it in the database.
  * /room/read_assets.php - returns all objects
    of type ReportAsset belonging to room with the specified id 
    in JSON format 
  ### UserCreator <- Just for testing!
  * /creator/user_creator.php - creates a User object with 
 the specified login and password and persists it to database.
 This should only be used for testing purposes as it is not 
 a secured endpoint. No token/privileges verification is performed
 upon executing this script.
