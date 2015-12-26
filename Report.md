# Neighborhood
A nextdoor.com alternative

```
Dhishan Amaranath [N16909360]
-----------------------------
Naimesh Narsinghani [N17161714]
```

A website to bring your neighborhood right into your laptop and bring your whole community of neighbors closer as a family and make your environment a beautiful and a safer one.

The whole city is divided into a community of neighborhood and each neighborhood further into blocks. Each registered user belongs to a block and thus to its neighborhood. User can post any updates, messages, information with references to images, location etc. which he can make his fellow neighbors in his block or in his whole neighborhood read about. He will wise versa have access to the posts updated by his fellow neighbors. The user will have the feasibility to reply to a post or send a personnel message to the postee.  We care about the security. The user is only allowed to join a block only if he accepted by at least 3 members who are already a members of the block. The user also has the flexibility to make friends and post updates. He also can selectively pic his immediate neighbors to have an important updates posted directly displayed in his home page.

--------------------------------------------------------------------------------

## Indexed
> An users First Page

An Entering page for the user where he can login to the webpage.

**index.html**

![](http://i.imgur.com/pccnVlO.jpg)

If user is already a member of the service, He can enter the home page with a simple login.

**_Here's how it works in background:_**

On submitting, the html input form's values of username and password are getting validated through JavaScript functions connecting to a backend server using Ajax POST. Here From the UI, we send through more secure POST method to the datacheck.php file running on the server, where the user input values is being check whether is it matching with the current database or not. To save the server's load we are using the prepared functions on MYSQL. On connect, the user name and user id are saved in the php session variable and navigated to home page.

![](http://i64.tinypic.com/2psmtr9.png)

--------------------------------------------------------------------------------

## No Account Yet?
> There is no escape from this

_**New user Registration:**_
- If a user is a new member then, that user is asked to create account, through the signup link on the login page.
- On sign up page: A new tuple is inserted in user and user_login and then redirected to joinblock page for joining a block
- In joinblock: using maps, user is allowed to request for membership for his neighborhood and his block, requests need to accepted by 3 existing block members.

**_Here's how it works in background:_**

When user clicks signup link, the user is taken to signup page for registration into the service. New user should compulsory enter 4 valid fields : User Name, Password and an Confirm Password and Name and E-mail. Only after all the fields are validated the signup button is activated for the next procedure in registration.

_**Check Validation for following input:**_

**username:**  As username is unique in the database, we have to validate username simultaneously through jQuery by connecting to backend php file using Ajax POST to check in the database that if any other user has already has taken that username. This is done on the fly without the submit. Providing more lively feeling to the site. Along with this validity the username restrictions of being minimum of 4 digits and containing only alphanumeric characters are done through Regular Expressions.

**Email:**  Email should be in a valid format and is unique in the database. On the fly check is performed here too.

**Password:** Password is made to enter twice to avoid manual errors. Check between two fields on the fly.

_After successful validation, input values is being sent using POST to database. The PHP file at the server makes sure the data is consistent and enters into the database through prepared statements._

_The validations of existing username and email are done through prepared functions for optimal performance and reduce load at the server end._

![](http://i63.tinypic.com/11jq2c8.png)

--------------------------------------------------------------------------------

## JOIN A BLOCK
> This is where you enter the community

There are predefined blocks and neighbourhood. The user is allowed to enter the address which is auto suggested using the google api or the user can directly click on the location of the map. The site then provides the suggested blocks and the belonging neighbourhood. If the user location lies on the boundary of the block map, the user is given a choice to choose between neighbourhoods and blocks in the vicinity.

**_Here's how it works in background:_**

The HTML file joinblock.html along with a javascript file blockfinder.js we fill the complete webpage with the google maps, with functionality such as google autofill search, get the location through pointers, get the location through latitude and longitude. Once the user selects the location, the latitude and longitude is sent to the database to check which neighbourhood the location belongs to. Our database has a 4 point polygon created for each neighbourhood and saves them in the form of NE,NW,SW,SE Latitudes and longitudes. An PHP script running at the server verifies if the latitude and longitude the user selected lies in any of the neighbourhood. If the location appears to be in the boundary of an neighbourhood, the database send back the vicinity neighbourhoods too and is loaded into the combobox for the user to select at the website. Once the user decides the neighbourhood the neighbourhood and its id previously retrieved from the database is sent back to further get the blocks in the neighbourhood and the block the user belongs to which is once again calculated using the 4 point polygon algorithm used before. This time the polygon co-ordinates are sent back from the server to draw the semitransparent polygon on the map to display the boundary.

**Front End File:** joinblock.html, joinblock.css, blockfinder.js and the google Maps Api **Backednd:** blockfinder.php **Communication:** Ajax POST and return the values in encoded JSON format.

_An user is allowed to join a block only if the current residents of the block approve them. A minimum of 3 approvals are required for joining of the block. If there are less than the 3 persons in the block then all the existing users should approve of the membership._

_The database schema consists of a m_request table which keeps record of the membership requests and the users who approved them and number of people more required for the user to be in the block. We also store the accepted time stamp which gets updated once all the minimum approvals which is then used to notify the users based on their last login time about their membership and they neighbors._

![](http://s10.postimg.org/bs78q6t2x/flow2.png)

--------------------------------------------------------------------------------

## Homepage
> It all begins here

Homepage is where the user enters on each successful login. The home page is a bootstrap navigation enhanced, tab based page. The Main Sections accessible through various methods are as follows:
- Update Page
  - Entire Neighbourhood posts
  - Only Block Related posts

- Friend Page
  - Friend posts
  - Personal message to friends
  - Add and search for people for friendship

- Neighbor Page
- Profile Page

**_Update Page:_**

It's the starting and the main page of the website. This page has two tabs one for each scope and neighborhood and block scope. The page consists of the posts or updates posted by fellow members of the block and neighbourhood.

Each Post is organized as a thread which contains an optional image, an optional location, a subject and message body. Each such thread can have many messages usually replied are associated with it. This is stored appropriately in database organized as threads and messages, Here the threads are like the containers for messages and the message consists of the following fields _Messageid_, _author_, _messagebody_, _latitude, longitude, path for image, thread id_ and the _timestamp_. And the _subject_ and the _scope_ stored in the threads.

![](http://s11.postimg.org/lztjoegar/Screen_Shot_2015_12_25_at_9_10_46_PM.png)

**_Friend Page:_**

This page has three main section all related to networking among the community. The database is organized to store the friendship related information into certain schemas. If a user decides to be a friend of a member he can send a request which can be approved by the other person. A schema just like m_request as we saw above is used to temporarily store the data. The other schema called the relationship commonly stores the relationship between two members as either a friendship or neighbor.

Once a tab corresponding to the friend is clicked the details regarding the current friends is shown, An search box to search for people and a message box to send a personal message to any friend.

![](http://s30.postimg.org/88vorj0w1/Screen_Shot_2015_12_25_at_9_30_12_PM.png)

**_Neighbor page_**

It is very similar to the friend page accept that it is only one way.

**_Profile page_**

Profile page has various functionalities related to the user himself. He can change his display picture, edit his name, join or leave the current block etc.

![](http://s14.postimg.org/uw14cykkh/Screen_Shot_2015_12_25_at_9_28_50_PM.png)

_Additionally the webpage has a notification section, Providing notification regarding the friend requests, personnel messages, block requests_

![](http://s30.postimg.org/yc3278doh/Screen_Shot_2015_12_25_at_11_09_57_PM.png)

--------------------------------------------------------------------------------

## create ,read or reply to a message
- a user can to create a message on home page for neighbourhoods, with a subject,images, and option for current location.

![](http://s24.postimg.org/mwlycpb1h/Screen_Shot_2015_12_25_at_9_11_44_PM.png)
- a user can receives/create personal messages in the messages block from any friend where the scope id is a user id
- a user can reply to personal/neighborhoods messages.
- ![](http://s30.postimg.org/m32vix3y9/Screen_Shot_2015_12_25_at_9_12_21_PM.png)

**_Here's how it works in background:_**

a user can create/reply a message on home page for neighbourhoods, with  a subject,images, and option for current location. On click to create message, we post user input values subject,message,image,latitude,longitude,scope with a flag through Ajax to php file to insert the data to threads,and to messages.

```
Ex:
var fd = new FormData();
fd.append('img', $('#uploadfilen_f')[0].files[0] );
fd.append('msg_body',$('#new-thread-body_f').val());
fd.append('subject',$('#new-thread-subject_f').val());
fd.append('latitude',$('#latitude_new_post_f').val());
fd.append('longitude',$('#longitude_new_post_f').val());     
$.ajax({
    url: 'phpScripts/dashboard.php',
    data: fd,
    processData: false,
    contentType: false,
    type: 'POST',
    success: function(data){
      alert(data);
      //reload the current post
    }
  });
```

**_Backend Sample Processing_**

```
$create_thread = "INSERT INTO `nextdoordb`.`threads`(`tid`,`subject`,`scope`,`scope_id`,`start_time`) VALUES (NULL,:subject,:scope,:scopeid,CURRENT_TIMESTAMP)";
$stmp_create_thread = $conn->prepare($create_thread);
$stmp_create_thread->bindParam(':subject',$_POST['subject'],PDO::PARAM_STR,40);
$stmp_create_thread->bindParam(':scope',$_POST['scope'],PDO::PARAM_STR);
if($_POST['scope'] == "neighbourhood"){
  $stmp_create_thread->bindParam(':scopeid',$_SESSION['nid'],PDO::PARAM_INT,6);
}else if($_POST['scope'] == "personnel"){
  $stmp_create_thread->bindParam(':scopeid',$_POST['scopeid'],PDO::PARAM_INT,6);
}else {
  $stmp_create_thread->bindParam(':scopeid',$_SESSION['bid'],PDO::PARAM_INT,6);
}
$stmp_create_thread->execute();

if(isset($_FILES["img"])){
  $check = getimagesize($_FILES["img"]["tmp_name"]);
  if($check !== false) {
      $filename = "../uploads/msg_".$mid;
      $target_file = $filename . basename($_FILES["img"]["name"]);
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      $filename_full = $filename.".".$imageFileType;
      $tst = move_uploaded_file($_FILES["img"]["tmp_name"], $filename_full);
      $relpath="uploads/msg_".$mid.".".$imageFileType;
  }
}
```

![](http://s28.postimg.org/e1e85jjel/flow3.png)
