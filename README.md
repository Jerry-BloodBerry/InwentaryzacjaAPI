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
* /login/addLoginSession - creates session for a user that has an
account in the database. Returns a token allowing the user
to make requests listed below.
### Asset
* /asset/getAssetInfo/{id} - returns object of type Asset with
 the specified id along with its AssetType, Room and Building
 in JSON format.
* /asset/addNewAsset - when passed complete data it creates
 an Asset object and persists it in the database.
 ### Building
 * /building/getBuildings - returns all objects of type Building in JSON
 format.
 * /building/addNewBuilding - when passed complete data it creates
  a Building object and persists it in the database.
 * /building/getRooms/{id} - returns all objects of type 
   Room belonging to the building with the specified id in JSON format.
 ### ReportHeader
  * /report/getReportsHeaders - returns all objects of type ReportHeader
   in JSON format.
  * /report/getReportHeader/{id} - returns object of type ReportHeader
   with the specified id in JSON format.
  * /report/addNewReport - when passed complete data it creates
   a Report object and persists it in the database.
  * /report/getReportPositions/{id} - returns all assets
    of type ReportAsset, that were inside the report with the given
    id, in JSON format
  ### Room
  * /room/addNewRoom - when passed complete data it creates
  a Room object and persists it in the database.
  * /room/getAssetsInRoom/{id} - returns all objects
    of type ReportAsset belonging to room with the specified id 
    in JSON format 
  ### UserCreator <- Just for testing!
  * /creator/user_creator - creates a User object with 
 the specified login and password and persists it to database.
 This should only be used for testing purposes as it is not 
 a secured endpoint. No token/privileges verification is performed
 upon executing this script.
