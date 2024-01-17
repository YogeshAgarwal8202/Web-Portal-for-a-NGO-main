var express = require('express');
var router = express.Router();
var mysql = require('mysql');

//Database connection
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : '',
  database : 'myproject'
});
connection.connect(function(err){
  if(!err){
    console.log("Database is connected");
  }
  else{
    console.log("Error in connecting database");
  }
});

/* GET home page. */
router.get('/admin_home',function(req, res, next) {
  connection.query("SELECT donation_id ,SUM(donation_amount) as total FROM donation_tbl",function(err,rows1){
    connection.query(`SELECT
    user_master.user_name
    , feedback_tbl.feedback_description
    , feedback_tbl.feedback_time
FROM
    myproject.user_master
    INNER JOIN myproject.feedback_tbl 
        ON (user_master.user_id = feedback_tbl.user_id);`,function(err,rows2){
      connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows3){
        connection.query(`SELECT
        user_master.user_name
        , donation_tbl.donation_amount
        , donation_tbl.donation_time
    FROM
        myproject.user_master
        INNER JOIN myproject.donation_tbl 
            ON (user_master.user_id = donation_tbl.user_id);`,function(err,rows4){
          connection.query("SELECT COUNT(feedback_id) as cnt FROM feedback_tbl;",function(err,rows5){
            connection.query("SELECT COUNT(event_id) as evt FROM event_tbl;",function(err,rows6){
              connection.query("SELECT COUNT(category_id) as cat FROM category_tbl;",function(err,rows7){
                connection.query("SELECT COUNT(user_id) as usr FROM user_master;",function(err,rows8){
                  console.log(rows1,rows2,rows3)
                  res.render('admin_home',{recent_donation:rows4,recent_feedback:rows2,recent_event:rows3,donation:rows1,feedback:rows5,event:rows6,category:rows7,user:rows8});
                });
              });
            });
          });
        });
      });
    });
  });
});




router.get('/view_event_category', function(req, res, next){
  connection.query("select * from category_tbl",function(err,db_rows){
    if(err)throw err;
    console.log(db_rows);
    if(req.session.user_password)
    {
      res.render('view_event_category', {db_rows_array:db_rows});
    }
    else{
      res.redirect('/users/login');
    }
  })
});


router.get('/delete_event_category/:category_id', function(req, res, next){
  var deleteid = req.params.category_id;
  if(req.session.user_password)
    {
      console.log("Delete id is: "+ deleteid);
      connection.query("delete from category_tbl where category_id = ?",[deleteid],function(err,db_rows){
        if(err)throw err;
        console.log(db_rows);
        console.log("Record Deleted");
        res.redirect('/view_event_category');
      })
    }
    else{
      res.redirect('/users/login');
  }
});

router.get('/edit_event_category/:category_id', function(req, res, next){
  console.log("Edit category id is" + category_id);
  var category_id = req.params.category_id;
  
  connection.query("select * from category_tbl where category_id = ?",[category_id],function(err,db_rows){
    if(err)throw err;
    console.log(db_rows);
    res.render('edit_event_category', {db_rows_array:db_rows});
  })
});

router.post('/edit_event_category/:category_id', function(req, res, next){
  console.log("Edited category:" + category_id);
  var category_id = req.params.category_id;
  var category_name = req.body.category_name;
  var category_description = req.body.category_description;

  console.log(req.files);
  var fileobj = req.files.category_image;
  var filename = req.files.category_image.name;
  var filesize = req.files.category_image.size;
  var mimetype = req.files.category_image.mimetype;

  if(mimetype=="image/png" && filesize < 1*1024*1024)
  {
    fileobj.mv("public/upload/category/"+filename, function(err){
      if(err)
        return console.log("File not uploaded");
      else{
        connection.query("update category_tbl set category_name = ? , category_description = ? , category_image = ? where category_id = ?",[category_name,category_description,filename,category_id],function(err,db_rows){
          if(err) throw err;
          res.redirect('/view_event_category');
        });
        return console.log("File UPLOADED");
      }
    });  
  }
  else{
    console.log("File must be image and of less than 1mb");
  }
});

router.post('/add_event', function(req, res, next) {

  console.log(req.body)
  var user_id=req.session.user_id;
  var event_id = req.body.event_id;
  var category_id = req.body.category_id;
  var event_title = req.body.event_title;
  var event_details = req.body.event_details;
  var event_date = req.body.event_date;
  var event_time = req.body.event_time;
  var event_location = req.body.event_location;
  var event_status = req.body.eventstatus;
  var event_coordinates = req.body.event_coordinates;
  var event_chat_group_link = req.body.event_chat_group_link;
  
  console.log(req.files);
  var fileobj = req.files.image_path;
  var filename = req.files.image_path.name;
  var filesize = req.files.image_path.size;
  var mimetype = req.files.image_path.mimetype;

  if(mimetype=="image/png" && filesize < 1*1024*1024)
  {
    fileobj.mv("public/upload/event_background/"+filename, function(err){
      if(err)
        return console.log("File not uploaded");
      else{
        connection.query("Select max(event_activity_num) as big from event_tbl",function(err,result1){
          var act_num= result1[0].big + 1;
        connection.query("insert into event_tbl(event_id,event_activity_num,category_id,event_title,event_details,event_date,event_time,event_location,event_status,image_path,event_coordinates,event_chat_group_link,event_last_updated_by) values (?,?,?,?,?,?,?,?,?,?,?,?,?)",[event_id,act_num,category_id,event_title,event_details,event_date,event_time,event_location,event_status,filename,event_coordinates,event_chat_group_link,user_id],function(err,result){
          if(err) throw err;
          res.redirect('/add_event');
        });
        });
        return console.log("File UPLOADED");
      }
    });  
  }
  else{
    console.log("File must be image and of less than 1mb");
  }
});

router.get('/view_events', function(req, res, next){
  if(req.session.user_password)
    {
      connection.query(`SELECT
      event_tbl.event_id
      , event_tbl.event_activity_num
      , category_tbl.category_name
      , event_tbl.event_title
      , event_tbl.event_details
      , event_tbl.event_date
      , event_tbl.event_time
      , event_tbl.event_location
      , event_tbl.event_status
      , event_tbl.image_path
      , event_tbl.event_coordinates
      , event_tbl.event_chat_group_link
      , user_master.user_name
  FROM
      myproject.event_tbl
      INNER JOIN myproject.category_tbl 
          ON (event_tbl.category_id = category_tbl.category_id)
      INNER JOIN myproject.user_master 
          ON (event_tbl.event_last_updated_by = user_master.user_id);
  `,function(err,db_rows){
   
        if(err)throw err;
        console.log(db_rows);
        res.render('view_events', {db_rows_array:db_rows});
    });
  }
  else{
    res.redirect('/users/login');
  }
});

router.get('/delete_event/:id', function(req, res, next){
  var deleteid = req.params.id;
  console.log("Delete id is: "+ deleteid);
  if(req.session.user_password)
    {
      connection.query("delete from event_tbl where event_id = ?",[deleteid],function(err,db_rows){
      if(err)throw err;
      console.log(db_rows);
      console.log("Record Deleted");
      res.redirect('/view_events');
      })
    }
    else{
      res.redirect('/users/login');
    }
});

router.get('/edit_event/:event_id', function(req, res, next){
  var event_id = req.params.event_id;
  console.log("Edit event id is" + event_id);
    
  connection.query("select * from category_tbl",function(err,rows1){
  connection.query("select * from event_tbl where event_id = ?",[event_id],function(err,db_rows){
    if(err)throw err;
    console.log(db_rows);
    res.render('edit_event', {db_rows_array:db_rows,category:rows1});
  });
});
});

router.post('/edit_event/:event_id', function(req, res, next){
  console.log("Edited category:" + event_id);
  var event_id = req.params.event_id;
  var category_id = req.body.category_id;
  var event_title = req.body.event_title;
  var event_details = req.body.event_details;
  var event_date = req.body.event_date;
  var event_time = req.body.event_time;
  var event_location = req.body.event_location;
  var event_status = req.body.event_status;
  var event_coordinates = req.body.event_coordinates;
  var event_chat_group_link = req.body.event_chat_group_link;
  var user_id=req.session.user_id;

  console.log(req.files);
  var fileobj = req.files.image_path;
  var filename = req.files.image_path.name;
  var filesize = req.files.image_path.size;
  var mimetype = req.files.image_path.mimetype;

  if(mimetype=="image/png" && filesize < 1*1024*1024)
  {
    fileobj.mv("public/upload/event_background/"+filename, function(err){
      if(err)
        return console.log("File not uploaded");
      else{
        connection.query("Select max(event_activity_num) as big from event_tbl",function(err,result1){
          var act_num= result1[0].big + 1;
        connection.query("update event_tbl set category_id = ?, event_activity_num = ?, event_title = ?, event_details = ?, event_date = ?, event_time = ?, event_location = ?, event_status = ?, image_path = ?, event_coordinates = ?, event_chat_group_link = ?, event_last_updated_by = ? where event_id = ?",[category_id,act_num,event_title,event_details,event_date,event_time,event_location,event_status,filename,event_coordinates,event_chat_group_link,user_id,event_id],function(err){
          if(err) throw err;
          res.redirect('/view_event');
        });
        return console.log("File UPLOADED");
      });
      }
    });
  }
  else{
    console.log("File must be image and of less than 1mb");
  }
});


router.get('/add_photos', function(req, res, next) {
  if(req.session.user_password)
    {
      connection.query("select * from event_tbl ",function(err,db_rows1){
       res.render('add_photos', { db_rows: db_rows1 });
      });
    }
    else{
      res.redirect('/users/login');
    }
});


router.post('/add_event_images', function(req, res, next) {

  console.log(req.body)
  var event_id = req.body.event_id;
  
  console.log(req.files);
  var fileobj = req.files.image_path;
  var filename = req.files.image_path.name;
  var filesize = req.files.image_path.size;
  var mimetype = req.files.image_path.mimetype;

  if(mimetype=="image/png" && filesize < 1*1024*1024)
  {
    fileobj.mv("public/upload/events/"+filename, function(err){
      if(err)
        return console.log("File not uploaded");
      else{
        connection.query("insert into event_image_tbl(event_id,image_path) values (?,?)",[event_id,filename],function(err,result){
          if(err) throw err;
          res.redirect('/add_photos');
        });
        return console.log("File UPLOADED");
      }
    });  
  }
  else{
    console.log("File must be image and of less than 1mb");
  }
  
});

router.get('/view_photos', function(req, res, next){
  if(req.session.user_password)
    {
      connection.query('SELECT event_image_tbl.event_image_id, event_tbl.event_title, event_image_tbl.image_path FROM myproject.event_image_tbl INNER JOIN myproject.event_tbl ON (event_image_tbl.event_id = event_tbl.event_id);',function(err,db_rows){
      if(err)throw err;
      console.log(db_rows);
      res.render('view_photos', {db_rows_array:db_rows});
  })
}
else{
  res.redirect('/users/login');
}
});

router.get('/delete_photos/:id', function(req, res, next){
  var deleteid = req.params.id;
  console.log("Delete id is: "+ deleteid);
  if(req.session.user_password)
    {
      connection.query("delete from event_image_tbl where event_image_id = ?",[deleteid],function(err,db_rows){
        if(err)throw err;
        console.log(db_rows);
        console.log("Record Deleted");
        res.redirect('/view_photos');
      });
    }
    else{
      res.redirect('/users/login');
    }
});

router.get('/edit_photos/:event_image_id', function(req, res, next){
  console.log("Edit category id is" + event_image_id);
  var event_image_id = req.params.event_image_id;
  connection.query("select * from event_image_tbl where event_image_id = ?",[event_image_id],function(err,db_rows){
    if(err)throw err;
    console.log(db_rows);
    res.render('edit_photos', {db_rows_array:db_rows});
  })
});

router.post('/add_donation', function(req, res, next) {
  console.log(req.body)
  var donation_date = req.body.donation_date
  var donation_time = req.body.donation_time
  var donation_amount = req.body.donation_amount
  var donation_method = req.body.donation_method
  var user_id = req.body.user_id
  connection.query("insert into donation_tbl(donation_date,donation_time,donation_amount,donation_method,user_id) values (?,?,?,?,?)",[donation_date,donation_time,donation_amount,donation_method,user_id],function(err,result){
    if(err) throw err;
    res.redirect('/add_donation');
  });
});

router.get('/add_location', function(req, res, next) {
  if(req.session.user_password)
    {
      res.render('add_location');
    }
    else{
      res.redirect('/users/login');
    }
});

router.post('/add_location', function(req, res, next) {
  console.log(req.body)
  var location_name = req.body.location_name
  connection.query("insert into location_tbl(location_name) values (?)",[location_name],function(err,result){
    if(err) throw err;
    res.redirect('/add_location');
  })
});

router.get('/view_location', function(req, res, next){
  if(req.session.user_password)
    {
      connection.query("select * from location_tbl",function(err,db_rows){
      if(err)throw err;
      console.log(db_rows);
      res.render('view_location', {db_rows_array:db_rows});
  })
}
else{
  res.redirect('/users/login');
}
});

router.get('/edit_location/:location_id', function(req, res, next){
  console.log("Edit location id is" + location_id);
  var location_id = req.params.location_id;
  
  connection.query("select * from location_tbl where location_id = ?",[location_id],function(err,db_rows){
    if(err)throw err;
    console.log(db_rows);
    res.render('edit_location', {db_rows_array:db_rows});
  })
});

router.post('/edit_location/:location_id', function(req, res, next){
  console.log("Edited location:" + location_id);
  var location_id = req.params.location_id;
  var location_name = req.body.location_name;
  connection.query("update location_tbl set location_name = ? where location_id = ?",[location_name,location_id],function(err,db_rows){
    if(err)throw err;
    console.log(db_rows);
    res.redirect('/view_location');
  })
});

router.get('/delete_location/:id', function(req, res, next){
  var deleteid = req.params.id;
  console.log("Delete id is: "+ deleteid);
  if(req.session.user_password)
    {
        connection.query("delete from location_tbl where location_id = ?",[deleteid],function(err,db_rows){
        if(err)throw err;
        console.log(db_rows);
        console.log("Record Deleted");
        res.redirect('/view_location');
  })
}
else{
  res.redirect('/users/login');
}
});

router.get('/view_feedback', function(req, res, next){
  connection.query(`SELECT
  feedback_tbl.feedback_id
  , feedback_tbl.feedback_date
  , feedback_tbl.feedback_time
  , feedback_tbl.feedback_description
  , event_tbl.event_title
  , user_master.user_name
FROM
  myproject.feedback_tbl
  INNER JOIN myproject.event_tbl 
      ON (feedback_tbl.event_id = event_tbl.event_id)
  INNER JOIN myproject.user_master 
      ON (feedback_tbl.user_id = user_master.user_id);
`,function(err,db_rows){
    if(err)throw err;
    console.log(db_rows);
    res.render('view_feedback', {db_rows_array:db_rows});
  })
});

router.get('/delete_feedback/:id', function(req, res, next){
  var deleteid = req.params.id;
  console.log("Delete id is: "+ deleteid);
  if(req.session.user_password)
    {
      connection.query("delete from feedback_tbl where feedback_id = ?",[deleteid],function(err,db_rows){
      if(err)throw err;
      console.log(db_rows);
      console.log("Record Deleted");
      res.redirect('/view_feedback');
    })
  }
  else{
    res.redirect('/users/login');
  }
});

/*router.get('/add_users', function(req, res, next) {
  if(req.session.user_password)
    {
      connection.query("select * from location_tbl ",function(err,db_rows3){
     
      res.render('add_users',{location:db_rows3});
      });
    }
    else{
      res.redirect('/users/login');
    }
});
*/
router.post('/add_users', function(req, res, next) {
  console.log(req.body);
  var user_name = req.body.user_name;
  var user_gender = req.body.user_gender;
  var user_dob = req.body.user_dob;
  var user_email = req.body.user_email;
  var user_password = req.body.user_password;
  var user_mobile = req.body.user_mobile;
  var user_country_code = req.body.user_country_code;
  var user_blood_group = req.body.user_blood_group;
  var user_health_issue = req.body.user_health_issue;
  var user_last_date_donation = req.body.user_last_date_donation;
  var user_location = req.body.user_location;
  var user_prefered_category = req.body.user_prefered_category;
  var usertype=req.body.usertype;
  console.log(usertype);

  console.log(req.files);
  var fileobj = req.files.user_image;
  var filename = req.files.user_image.name;
  var filesize = req.files.user_image.size;
  var mimetype = req.files.user_image.mimetype;
 // console.log(fileobj)
  if(mimetype=="image/png" && filesize < 1*1024*1024)
  {
    fileobj.mv("public/upload/users/"+filename, function(err){
      if(err)
      {
        return console.log("File not uploaded");
      }
        else
      {
        connection.query("insert into user_master(user_name,user_image,user_gender,user_dob,user_email,user_password,user_mobile,user_country_code,user_blood_group,user_health_issue,user_last_date_donation,user_location,user_prefered_category,type_id) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)",[user_name,filename,user_gender,user_dob,user_email,user_password,user_mobile,user_country_code,user_blood_group,user_health_issue,user_last_date_donation,user_location,user_prefered_category,usertype],function(err,result){
          if(err) throw err;
          res.redirect('/add_users');
        });
        return console.log("File UPLOADED");
      }
    });  
  }
  else{ 
    console.log("File must be image and of less than 1mb");
  }
});

router.get('/view_user', function(req, res, next){
  if(req.session.user_password)
    {
        connection.query(`SELECT
        user_master.user_id
        , user_master.user_image
        , user_master.user_name
        , user_master.user_gender
        , user_master.user_mobile
        , user_master.user_blood_group
        , user_master.user_health_issue
        , user_master.user_last_date_donation
        , user_master.user_email
        , user_master.user_location
        , category_tbl.category_name
    FROM
        myproject.user_master
        INNER JOIN myproject.category_tbl 
            ON (user_master.user_prefered_category = category_tbl.category_id);
    `,function(err,db_rows){
        if(err)throw err;
        console.log(db_rows);
        res.render('view_user', {db_rows_array:db_rows});
      })
    }
    else{
      res.redirect('/users/login');
    }
});

router.get('/delete_user/:user_id', function(req, res, next){
  var deleteid = req.params.user_id;
  console.log("Delete id is: "+ deleteid);
  if(req.session.user_password)
    {
        connection.query("delete from user_master where user_id = ?",[deleteid],function(err,db_rows){
        if(err)throw err;
        console.log(db_rows);
        console.log("Record Deleted");
        res.redirect('/view_user');
      })
    }
    else{
      res.redirect('/users/login');
    }
});

router.get('/edit_users/:user_id', function(req, res, next) {
  var user_id = req.params.user_id;
  console.log("Edit user id is" + user_id);
  
        connection.query("select * from user_master WHERE user_id = ?",[user_id],function(err,db_rows){
          connection.query("select * from location_tbl ",function(err,db_rows3){
            connection.query("select * from category_tbl ",function(err,db_rows5){

        if(req.session.user_password)
        {
          res.render("edit_users",{db_rows_array: db_rows,location_array:db_rows3,category:db_rows5});
              
        }
        else
        {
          res.redirect("/users/login");
        }
            });
          });
        });
});

router.post('/edit_users/:user_id', function(req, res, next){
  var user_id = req.params.user_id;
  console.log("Edited User is :" + user_id);
  var user_name = req.body.user_name;
  var user_dob = req.body.user_dob;
  var user_gender= req.body.user_gender;
  var user_mobile = req.body.user_mobile ;
  var user_email= req.body.user_email;
  var user_location= req.body.user_location;
  var user_country_code= req.body.user_country_code;
  var user_prefered_category= req.body.user_prefered_category;
  var user_blood_group= req.body.user_blood_group;
  var user_last_date_donation= req.body.user_last_date_donation;
  var user_health_issue= req.body.user_health_issue;
  var user_type= req.body.usertype;


  console.log(req.files);
  var fileobj = req.files.user_image;
  var filename = req.files.user_image.name;
  var filesize = req.files.user_image.size;
  var mimetype = req.files.user_image.mimetype;

  if(mimetype=="image/png" && filesize < 1*1024*1024)
  {
    fileobj.mv("public/upload/users/"+filename, function(err){
      if(err)
        return console.log("File not uploaded");
      else{
        connection.query("update user_master set user_name = ? , type_id = ? , user_image  = ?, user_dob = ? , user_gender = ? , user_mobile  = ?, user_email = ?, user_location = ?, user_country_code = ?, user_prefered_category = ?, user_blood_group = ?, user_last_date_donation = ?, user_health_issue = ? where user_id = ?",[user_name,user_type,filename,user_dob,user_gender,user_mobile,user_email,user_location,user_country_code,user_prefered_category,user_blood_group,user_last_date_donation,user_health_issue,user_id],function(err){
          if(err) throw err;
          res.redirect('/view_user');
        });
        return console.log("File UPLOADED");
      }
    });  
  }
  else{
    console.log("File must be image and of less than 1mb");
  }
});




router.get('/view_donation', function(req, res, next){
  if(req.session.user_password)
    {
        connection.query(`SELECT
        user_master.user_id
        , donation_tbl.donation_id
        , donation_tbl.donation_date
        , donation_tbl.donation_time
        , donation_tbl.donation_amount
        , donation_tbl.donation_method
        , user_master.user_name
        , donation_tbl.donation_status
        , donation_tbl.user_id
    FROM
        user_master
        INNER JOIN donation_tbl 
            ON (user_master.user_id = donation_tbl.user_id)`,function(err,db_rows){
        if(err)throw err;
        console.log(db_rows);
        res.render('view_donation', {db_rows_array:db_rows});
      });
    }
    else{
      res.redirect('/users/login');
    }
});

router.get('/add_donation', function(req, res, next) {
  if(req.session.user_password)
    {
      res.render('add_donation', { title: 'Express' });
    }
    else{
      res.redirect('/users/login');
    }
});

/*router.get('/edit_donation/:donation_id', function(req, res, next){
  console.log("Edit donation id is" + donation_id);
  var donation_id = req.params.donation_id;
  
  connection.query("select * from donation_tbl where donation_id = ?",[donation_id],function(err,db_rows){
    if(err)throw err;
    console.log(db_rows);
    res.render('edit_donation', {db_rows_array:db_rows});
  })
});

router.post('/edit_donation/:donation_id', function(req, res, next){
  console.log("Edited donation:" + donation_id);
  var donation_id = req.params.donation_id;
  var donation_date = req.body.donation_date;
  var donation_time = req.body.donation_time;
  var donation_amount = req.body.donation_amount;
  var donation_method = req.body.donation_method;
  var user_id = req.body.user_id;
  connection.query("update donation_tbl set donation_date = ?, donation_time = ?, donation_amount = ?, donation_method = ?, user_id = ? where donation_id = ?",[donation_date,donation_time,donation_amount,donation_method,user_id,donation_id],function(err,db_rows){
    if(err)throw err;
    console.log(db_rows);
    res.redirect('/view_donation');
  })
});*/


router.get('/add_event_category', function(req, res, next) {
  if(req.session.user_password)
    {
      res.render('add_event_category', { title: 'Express' });
    }
    else{
      res.redirect('/users/login');
    }
});

router.post('/add_event_category', function(req, res) {
  console.log(req.body)
  var category_name = req.body.category_name
  var category_description = req.body.category_description
  
  console.log(req.files);
  var fileobj = req.files.category_image;
  var filename = req.files.category_image.name
  var filesize = req.files.category_image.size
  var mimetype = req.files.category_image.mimetype

  if(mimetype=="image/png" && filesize < 2*1024*1024)
  {
    fileobj.mv("public/upload/category/"+filename, function(err){
      if(err)
        return console.log("File not uploaded" + err);
      else{
        connection.query("insert into category_tbl(category_name,category_description,category_image) values (?,?,?)",[category_name,category_description,filename],function(err,result){
          if(err) throw err;
          res.redirect('/add_event_category');
        });
        return console.log("File UPLOADED");
      }
    });  
  }
  else{
    console.log("File must be image and of less than 1mb");
  }
});


router.get('/add_event', function(req, res, next) {
  if(req.session.user_password)
    {
      connection.query("select * from category_tbl ",function(err,rows4){
      res.render('add_event', { category_info : rows4});
    });
    }
    else{
      res.redirect('/users/login');
    }
});

router.get('/add_users', function(req, res, next) {
  if(req.session.user_password)
    {
      connection.query("select * from category_tbl ",function(err,rows1){
        connection.query("select * from location_tbl ",function(err,db_rows3){
      res.render('add_users', {category:rows1,location:db_rows3});
      });
    });
    }
    else{
      res.redirect('/users/login');
    }
});

router.get('/charts', function(req, res, next) {
  if(req.session.user_password)
    {
      res.render('charts', { title: 'Express' });
    }
    else{
      res.redirect('/users/login');
    }
});

/*router.get('/login', function(req, res, next) {
  res.render('login');
});

router.post('/loginsession', function(req, res, next) {
  console.log('Login Process Called')
  var user_email=req.body.user_email;
  var user_password=req.body.user_password;
  req.session.myuser=user_email;
  req.session.myuserpassword=user_password;
  console.log('Session Value ' +req.session.myuser);
  console.log('Session Value ' +req.session.myuserpassword);
  res.redirect('admin_home');
 });*/

router.get('/send_notifications', function(req, res, next) {
  if(req.session.user_password)
    {
      res.render('send_notifications', { title: 'Express' });
    }
    else{
      res.redirect('/users/login');
    }
});

router.post('/send_notifications', function(req, res, next) {
  var user_list  = req.body.sendto.value;
  if (user_list == "Adminstrators")
  {
      var user_type=5;
  }
  else if (user_list == "Education of underprivileged children")
  {
      var user_type=2;
  }
  else if (user_list == "Public Healthcare")
  {
      var user_type=1;
  }
  else if (user_list == "Environmental Protection")
  {
      var user_type=2;
  }
  else if (user_list == "Joy of Giving")
  {
      var user_type=4;
  }
  else if (user_list == "All Contributors")
  {
      var user_type=6;
  }
  else
  {
      var user_type=7;
  }
  


  if(user_type == 6 )
  {
    connection.query("select user_email from user_master where user_prefered_category = ? or user_prefered_category = ? or user_prefered_category = ? or user_prefered_category = ?",[1,2,3,4],function(err,rows2){
    
      console.log(rows2)
      if(rows2.length>0)
      {
        var notificationheading = req.body.notificationheading;
        var notificationdescription = req.body.notificationdescription;
        var heading = `${notificationheading}`
                         "use strict";
        var msg = `${notificationdescription}`
                      "use strict";
                      console.log(msg)
              const nodemailer = require("nodemailer");

              // async..await is not allowed in global scope, must use a wrapper
              async function main() {
                for(var i=0; i<rows2.length;i++)
                {
                  // Generate test SMTP service account from ethereal.email
                  // Only needed if you don't have a real mail account for testing
                  let testAccount = await nodemailer.createTestAccount();

                  // create reusable transporter object using the default SMTP transport
                  let transporter = nodemailer.createTransport({
                    host: "smtp.gmail.com",
                    port: 587,
                    secure: false, // true for 465, false for other ports
                    auth: {
                      user: "maildemo445@gmail.com", // generated ethereal user
                      pass: "maildemo@123", // generated ethereal password
                    },
                  });

                  // send mail with defined transport object
                  let info = await transporter.sendMail({
                    from: '"Suryabala Seva Sansthan" <maildemo445@gmail.com>', // sender address
                    to: rows2[i].user_email, // list of receivers
                    subject: heading, // Subject line
                    text: msg, // plain text body
                    html:  msg, // html body
                  });

                  console.log("Message sent: %s", info.messageId);
                  // Message sent: <b658f8ca-6296-ccf4-8306-87d57a0b4321@example.com>

                  // Preview only available when sending through an Ethereal account
                  console.log("Preview URL: %s", nodemailer.getTestMessageUrl(info));
                  // Preview URL: https://ethereal.email/message/WaQKMgKddxQDoou...
                }
              }

              main().catch(console.error);

      }
      else
      {
        res.send("User Not Found");
      }
    
    });
  }
  else if(user_type == 7)
  {
    connection.query("select user_email from user_master ",function(err,rows1){
    
      if(rows1.length>0)
      {
        var notificationheading = req.body.notificationheading;
        var notificationdescription = req.body.notificationdescription;
        var heading = `${notificationheading}`
                         "use strict";
        var msg = `${notificationdescription}`
                      "use strict";
              const nodemailer = require("nodemailer");

              // async..await is not allowed in global scope, must use a wrapper
              async function main() {
                for(var i=0; i<rows1.length;i++)
                {
                  // Generate test SMTP service account from ethereal.email
                  // Only needed if you don't have a real mail account for testing
                  let testAccount = await nodemailer.createTestAccount();

                  // create reusable transporter object using the default SMTP transport
                  let transporter = nodemailer.createTransport({
                    host: "smtp.gmail.com",
                    port: 587,
                    secure: false, // true for 465, false for other ports
                    auth: {
                      user: "maildemo445@gmail.com", // generated ethereal user
                      pass: "maildemo@123", // generated ethereal password
                    },
                  });

                  // send mail with defined transport object
                  let info = await transporter.sendMail({
                    from: '"Suryabala Seva Sansthan" <maildemo445@gmail.com>', // sender address
                    to: rows1[i].user_email, // list of receivers
                    subject: heading, // Subject line
                    text: msg, // plain text body
                    html:  msg, // html body
                });

                console.log("Message sent: %s", info.messageId);
                // Message sent: <b658f8ca-6296-ccf4-8306-87d57a0b4321@example.com>

                // Preview only available when sending through an Ethereal account
                console.log("Preview URL: %s", nodemailer.getTestMessageUrl(info));
                // Preview URL: https://ethereal.email/message/WaQKMgKddxQDoou...
              }
            }

              main().catch(console.error);

      }
      else
      {
        res.send("User Not Found");
      }
    
  });
  }
  else{
    connection.query("select user_email from user_master where user_prefered_category = ? ",[user_type],function(err,rows){
    
      if(rows.length>0)
      {
        var notificationheading = req.body.notificationheading;
        var notificationdescription = req.body.notificationdescription;
        var heading = `${notificationheading}`
                         "use strict";
        var msg = `${notificationdescription}`
                      "use strict";
              const nodemailer = require("nodemailer");

              // async..await is not allowed in global scope, must use a wrapper
              async function main() {
                for(var i=0; i<rows.length;i++)
                {
                  // Generate test SMTP service account from ethereal.email
                  // Only needed if you don't have a real mail account for testing
                  let testAccount = await nodemailer.createTestAccount();

                  // create reusable transporter object using the default SMTP transport
                  let transporter = nodemailer.createTransport({
                    host: "smtp.gmail.com",
                    port: 587,
                    secure: false, // true for 465, false for other ports
                    auth: {
                      user: "maildemo445@gmail.com", // generated ethereal user
                      pass: "maildemo@123", // generated ethereal password
                    },
                  });

                  // send mail with defined transport object
                  let info = await transporter.sendMail({
                    from: '"Suryabala Seva Sansthan" <maildemo445@gmail.com>', // sender address
                    to: rows[i].user_email, // list of receivers
                    subject: heading, // Subject line
                    text: msg, // plain text body
                    html:  msg, // html body
                });

                console.log("Message sent: %s", info.messageId);
                // Message sent: <b658f8ca-6296-ccf4-8306-87d57a0b4321@example.com>

                // Preview only available when sending through an Ethereal account
                console.log("Preview URL: %s", nodemailer.getTestMessageUrl(info));
                // Preview URL: https://ethereal.email/message/WaQKMgKddxQDoou...
              }
            }

              main().catch(console.error);

      }
      else
      {
        res.send("User Not Found");
      }
    
  });

  }
  
});


router.get('/edit_ngo', function(req, res, next) {
  if(req.session.user_password)
    {
      res.render('edit_ngo', { title: 'Express' });
    }
    else{
      res.redirect('/users/login');
    }
});

router.get('/view_ngo', function(req, res, next){
  if(req.session.user_password)
    {
        connection.query("select * from ngo_info_tbl",function(err,db_rows){
        if(err)throw err;
        console.log(db_rows);
        res.render('view_ngo', {db_rows_array:db_rows});
      })
    }
    else{
      res.redirect('/users/login');
    }
});

router.get('/edit_ngo/:ngo_id', function(req, res, next){
  console.log("Edit ngo id is" + ngo_id);
  var ngo_id = req.params.ngo_id;
  
  connection.query("select * from ngo_info_tbl where ngo_id = ?",[ngo_id],function(err,db_rows){
    if(err)throw err;
    console.log(db_rows);
    res.render('edit_ngo', {db_rows_array:db_rows});
  })
});

router.post('/edit_ngo/:ngo_id', function(req, res, next){
  console.log("Edited ngo information:" + ngo_id);
  var ngo_id = req.params.ngo_id;
  var ngo_description = req.body.ngo_description;
  var ngo_address = req.body.ngo_address;
  var ngo_email = req.body.ngo_email;
  var ngo_mobile1 = req.body.ngo_mobile1;
  var ngo_mobile2 = req.body.ngo_mobile2;
  connection.query("update ngo_info_tbl set ngo_description = ?, ngo_address = ?, ngo_email = ?, ngo_mobile1 = ?, ngo_mobile2 = ? where ngo_id = ?",[ngo_description,ngo_address,ngo_email,ngo_mobile1,ngo_mobile2,ngo_id],function(err,db_rows){
    if(err)throw err;
    console.log(db_rows);
    res.redirect('/view_ngo');
  })
});


/*router.get('/remove_photos', function(req, res, next) {
  res.render('remove_photos', { title: 'Express' });
});*/

router.get('/view_volunteer_details', function(req, res, next){
  if(req.session.user_password)
    {
        connection.query(`SELECT
        volunteer_tbl.volunteer_id
        , user_master.user_name
        , event_tbl.event_title
    FROM
        myproject.volunteer_tbl
        INNER JOIN myproject.user_master 
            ON (volunteer_tbl.user_id = user_master.user_id)
        INNER JOIN myproject.event_tbl 
            ON (volunteer_tbl.event_id = event_tbl.event_id);
    `,function(err,db_rows){
        if(err)throw err;
        console.log(db_rows);
        res.render('view_volunteer_details', {db_rows_array:db_rows});
      })
    }
    else{
      res.redirect('/users/login');
    }
});


router.get('/add_team',function(req, res, next){
  if(req.session.user_password)
    {
      res.render('add_team', { title: 'Express' });
    }
    else{
      res.redirect('/users/login');
    }
});

router.post('/add_team', function(req, res, next) {
  console.log(req.body);
  var member_name = req.body.member_name;
  var member_role = req.body.member_role;
  var member_link = req.body.member_link;
  console.log(req.files);
  var fileobj = req.files.member_image;
  var filename = req.files.member_image.name;
  var filesize = req.files.member_image.size;
  var mimetype = req.files.member_image.mimetype;

  if(mimetype=="image/png" && filesize < 1*1024*1024)
  {
    fileobj.mv("public/upload/users/"+filename, function(err){
      if(err)
        return console.log("File not uploaded");
      else{
        connection.query("insert into team_member_tbl(member_name,member_role,member_link,member_image) values (?,?,?)",[member_name,member_role,member_link,filename],function(err,result){
          if(err) throw err;
          res.redirect('/add_users');
        });
        return console.log("File UPLOADED");
      }
    });  
  }
  else{
    console.log("File must be image and of less than 1mb");
  }
});

router.get('/view_team', function(req, res, next){
  if(req.session.user_password)
  {
      connection.query("select * from team_member_tbl",function(err,db_rows){
      if(err)throw err;
      console.log(db_rows);
      res.render('view_team', {db_rows_array:db_rows});
    })
  }
  else{
    res.redirect('/users/login');
  } 
});

router.get('/edit_team/:member_id', function(req, res, next){
  console.log("Edit team member id is" + member_id);
  var member_id = req.params.member_id;
  connection.query("select * from team_member_tbl where member_id = ?",[member_id],function(err,db_rows){
    if(err)throw err;
    console.log(db_rows);
    res.render('edit_team', {db_rows_array:db_rows});
  })
});

router.post('/edit_team/:member_id', function(req, res, next){
  console.log("Edited team member:" + member_id);
  var member_id = req.params.member_id;
  var member_name = req.body.member_name;
  var member_role = req.body.member_role;
  var member_link= req.body.member_link;

  console.log(req.files);
  var fileobj = req.files.member_image;
  var filename = req.files.member_image.name;
  var filesize = req.files.member_image.size;
  var mimetype = req.files.member_image.mimetype;

  if(mimetype=="image/png" && filesize < 1*1024*1024)
  {
    fileobj.mv("public/upload/users/"+filename, function(err){
      if(err)
        return console.log("File not uploaded");
      else{
        connection.query("update team_member_tbl set member_name = ? , member_role  = ?, member_link = ? , member_image = ? where member_id = ?",[member_name,member_role,member_link,filename,member_id],function(err,db_rows){
          if(err) throw err;
          res.redirect('/view_team');
        });
        return console.log("File UPLOADED");
      }
    });  
  }
  else{
    console.log("File must be image and of less than 1mb");
  }
});

router.get('/delete_team_member/:id', function(req, res, next){
  var deleteid = req.params.id;
  console.log("Delete id is: "+ deleteid);
  if(req.session.user_password)
    {
        connection.query("delete from team_member_tbl where member_id = ?",[deleteid],function(err,db_rows){
        if(err)throw err;
        console.log(db_rows);
        console.log("Record Deleted");
        res.redirect('/view_team');
      })
    }
    else{
      res.redirect('/users/login');
    }
});

router.get('/add_faq',function(req, res, next){
  if(req.session.user_password)
    {
      res.render('add_faq', { title: 'Express' });
    }
    else{
      res.redirect('/users/login');
    }
});

router.post('/add_faq', function(req, res, next) {
  //fileupload
  /*console.log(req.files);
  var fileobj = req.files.member_image;
  var filename = req.files.member_image.name;
  var filesize = req.files.member_image.size;
  var mimetype = req.files.member_image.mimetype;
  if(mimetype=="image/png" && filesize < 1*1024*1024)
  {
    fileobj.mv("public/team_photos/"+filename, function(err){
      if(err)
      return console.log("File not uploaded");
      else{
        res.redirect('/add_team');
      return console.log("File UPLOADED");
      
      }
    });  
  }
  else{
    console.log("File must be image and of less than 1mb");
  }*/
  console.log(req.body);
  var faq_question = req.body.faq_question;
  var faq_answer = req.body.faq_answer;
  connection.query("insert into faq_tbl(faq_question,faq_answer) values (?,?)",[faq_question,faq_answer],function(err,result){
    if(err) throw err;
    res.redirect('/add_faq');
  })
});

router.get('/view_faq', function(req, res, next){
  if(req.session.user_password)
    {
        connection.query("select * from faq_tbl",function(err,db_rows){
        if(err)throw err;
        console.log(db_rows);
        res.render('view_faq', {db_rows_array:db_rows});
      })
    }
    else{
      res.redirect('/users/login');
    }
});

router.get('/delete_faq/:id', function(req, res, next){
  var deleteid = req.params.id;
  console.log("Delete id is: "+ deleteid);
  if(req.session.user_password)
    {
        connection.query("delete from faq_tbl where faq_id = ?",[deleteid],function(err,db_rows){
        if(err)throw err;
        console.log(db_rows);
        console.log("Record Deleted");
        res.redirect('/view_faq');
      })
    }
    else{
      res.redirect('/users/login');
    }
});

router.get('/edit_faq/:faq_id', function(req, res, next){
  console.log("Edit faq id is" + faq_id);
  var faq_id = req.params.faq_id;
  
  connection.query("select * from faq_tbl where faq_id = ?",[faq_id],function(err,db_rows){
    if(err)throw err;
    console.log(db_rows);
    res.render('edit_faq', {db_rows_array:db_rows});
  })
});

router.post('/edit_faq/:faq_id', function(req, res, next){
  console.log("Edited faq information:" + faq_id);
  var faq_id = req.params.faq_id;
  var faq_question = req.body.faq_question;
  var faq_answer = req.body.faq_answer;
  connection.query("update faq_tbl set faq_question = ?, faq_answer = ? where faq_id = ?",[faq_question,faq_answer,faq_id],function(err,db_rows){
    if(err)throw err;
    console.log(db_rows);
    res.redirect('/view_faq');
  })
});


module.exports = router;
