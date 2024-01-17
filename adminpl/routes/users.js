var express = require('express');
var router = express.Router();
var mysql = require('mysql');
const { CLIENT_FOUND_ROWS } = require('mysql/lib/protocol/constants/client');

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

router.get('/', function(req, res, next) {
  var today = new Date();
  var curryear = today.getFullYear();
  var est = new Date(2015,08,12);
  var estyear = est.getFullYear();
  console.log(estyear);
  var exp = curryear-estyear;
  connection.query("select * from feedback_tbl ORDER BY `feedback_tbl`.`feedback_date` DESC",function(err,rows1){
   connection.query("select * from category_tbl",function(err,rows2){
    connection.query("select * from ngo_info_tbl",function(err,rows3){  
      connection.query("SELECT COUNT(volunteer_id) as vol FROM volunteer_tbl;",function(err,rows4){
        connection.query("SELECT COUNT(user_id) as usr FROM user_master where type_id=2;",function(err,rows5){
          connection.query("SELECT donation_id ,SUM(donation_amount) as total FROM donation_tbl",function(err,rows6){
            connection.query("SELECT COUNT(event_id) as evt FROM event_tbl;",function(err,rows7){
              connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows8){
              res.render('users/index',{category_info : rows2,feedback_info : rows1,ngo_info : rows3,volunteer:rows4,contributors:rows5,donations:rows6,event_held:rows7,event:rows8, experience : exp});
            });
          });
          });
        });
      });
    });
  });
});
});


router.get('/signup', function(req, res, next) {
  connection.query("select * from ngo_info_tbl",function(err,rows1){
    connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows2){
      connection.query("select * from location_tbl ",function(err,db_rows3){
        connection.query("select * from category_tbl ",function(err,rows4){
          
      res.render('users/signup',{ngo_info : rows1,event : rows2, location : db_rows3, category_info : rows4});
    });
  });
  });
  });
});

router.post('/signup', function(req, res, next) {
  console.log(req.body);
  var user_name = req.body.user_first_name + " " +req.body.user_last_name
  var user_gender = req.body.user_gender
  var user_dob = req.body.user_dob
  var user_email = req.body.user_email
  var user_password = req.body.user_password
  var user_mobile = req.body.user_mobile
  var user_country_code = req.body.user_country_code
  var user_blood_group = req.body.user_blood_group
  var user_health_issue = req.body.user_health_issue
  var user_location = req.body.user_location
  var user_prefered_category = req.body.user_prefered_category
  var user_health_issue= req.body.user_health_issue
  user_health_issue.trim();
  if (user_health_issue === '' || user_health_issue == null)
  {
    user_health_issue="Unknown";
  }

  connection.query("insert into user_master(type_id,user_name,user_gender,user_dob,user_email,user_password,user_mobile,user_country_code,user_blood_group,user_health_issue,user_location,user_prefered_category) values (1,?,?,?,?,?,?,?,?,?,?,?)",[user_name,user_gender,user_dob,user_email,user_password,user_mobile,user_country_code,user_blood_group,user_health_issue,user_location,user_prefered_category],function(err,result){
    if(err) throw err;
    res.redirect('/users/signup');
  });
});

router.get('/login', function(req, res, next) {
  connection.query("select * from ngo_info_tbl",function(err,rows1){
    connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows2){
      res.render('users/login',{ngo_info : rows1, event : rows2});
    });
  });
});

router.post('/login_process', function(req, res, next) {
  var user_mobile = req.body.user_mobile;
  var user_password = req.body.user_password;
  
  connection.query("select * from user_master where user_mobile = ? and user_password = ?",[user_mobile,user_password],function(err,rows){
    if (!err)
    {
      if(rows.length > 0){
        var user_mobile=rows[0].user_mobile;
        var user_password=rows[0].user_password;
        var user_id=rows[0].user_id;
        var user_name=rows[0].user_name;
        var user_email=rows[0].user_email;
        var type_id= rows[0].type_id;
        var last_blood_donation_date = rows[0].user_last_date_donation;
        var user_image=rows[0].user_image;

        //console
        req.session.user_mobile=user_mobile;
        req.session.user_password=user_password;
        req.session.user_id = user_id;
        req.session.user_name = user_name;
        req.session.user_email = user_email;
        req.session.type_id = type_id;
        req.session.last_blood_donation_date = last_blood_donation_date;
        req.session.user_image = user_image;
        


        console.log(req.session.user_id);
        console.log(req.session.user_mobile);
        console.log(req.session.user_password);
        console.log(req.session.user_name);
        console.log(req.session.user_email);
        console.log(req.session.type_id);
        if( rows[0].type_id == 2){
          res.redirect('/users/');
        }
        else if (rows[0].type_id == 1){
          res.redirect('/admin_home');
        }
        else{}
      }
    }
    else{
      res.send("Login Failed");
      //alert("Login Failed");
    }
  });
});

router.get('/logout',function(req,res,next){
  req.session.destroy(function(err){
    res.redirect("/users/");
  });
});

router.get('/events', function(req, res, next) {
  connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_date` DESC",function(err,rows1){
    connection.query("select * from ngo_info_tbl",function(err,rows2){ 
      connection.query("select * from category_tbl",function(err,rows3){
        connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows4){
          res.render('users/events',{event_info : rows1,ngo_info : rows2,category_info:rows3,event : rows4});
        });
      });
    });
  });
});


router.get('/eventsfilter/:id', function(req, res, next) {
  var id = req.params.id;
  connection.query("select * from event_tbl where category_id = ? order by event_date desc",[id],function(err,rows1){
    connection.query("select * from ngo_info_tbl  ",function(err,rows2){ 
      connection.query("select * from category_tbl",function(err,rows3){
        connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_date` DESC",function(err,rows4){
          res.render('users/events',{event_info : rows1,ngo_info : rows2,category_info:rows3,event:rows4});
        });
      });
    });
  });
});



router.get('/about', function(req, res, next) {
  var today = new Date();
  var curryear = today.getFullYear();
  var est = new Date(2015,08,12);
  var estyear = est.getFullYear();
  console.log(estyear);
  var exp = curryear-estyear;
  connection.query("select * from ngo_info_tbl",function(err,rows1){
    connection.query("select * from category_tbl",function(err,rows2){
      connection.query("SELECT COUNT(volunteer_id) as vol FROM volunteer_tbl;",function(err,rows4){
        connection.query("SELECT COUNT(user_id) as usr FROM user_master where type_id=2;",function(err,rows5){
          connection.query("SELECT donation_id ,SUM(donation_amount) as total FROM donation_tbl",function(err,rows6){
            connection.query("SELECT COUNT(event_id) as evt FROM event_tbl;",function(err,rows7){
              connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows8){
                res.render('users/about',{ngo_info : rows1,category_info : rows2,volunteer:rows4,contributors:rows5,donations:rows6,event_held:rows7,event:rows8, experience : exp});
              });
            });
          });
        });
      });
    });
  });
});


router.get('/gallery', function(req, res, next) {
  connection.query("select * from ngo_info_tbl",function(err,rows1){
    connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows2){
      res.render('users/gallery',{ngo_info : rows1,event:rows2});
    });
  });
});

router.get('/team', function(req, res, next) {
  connection.query("select * from team_member_tbl",function(err,rows1){
    connection.query("select * from ngo_info_tbl",function(err,rows2){
      connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows3){
        res.render('users/team',{member_info : rows1,ngo_info : rows2,event:rows3});
      });
    });
  });
});

router.get('/volunteer', function(req, res, next) {
  connection.query("select * from ngo_info_tbl",function(err,rows1){
    res.render('users/volunteer',{ngo_info : rows1});
  });
});

router.get('/faq', function(req, res, next) {
  connection.query("select * from faq_tbl",function(err,rows1){
    connection.query("select * from ngo_info_tbl",function(err,rows2){
      connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows3){
        res.render('users/faq',{faq_info : rows1,ngo_info : rows2,event:rows3});
      });
    });
  });
});

router.get('/contact', function(req, res, next) {
  connection.query("select * from ngo_info_tbl",function(err,rows){
    connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows1){
      res.render('users/contact',{ngo_info : rows,event:rows1});
    });
  });
});

router.get('/donation', function(req, res, next) {
  connection.query("select * from ngo_info_tbl",function(err,rows1){
    connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows2){
      if(req.session.user_password)
      {
        res.render("users/donation",{ngo_info : rows1,event:rows2});
      }
      else
      {
        res.redirect("/users/login");
      }
    });
  });
});

router.post('/donation', function(req, res, next) {
  console.log(req.body)
  var today = new Date();
  var mdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
  var mtime = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
  
  var donation_date = mdate;
  var donation_time = mtime;
  var donation_amount = req.body.donation_amount
  var user_id = req.session.user_id

  connection.query("insert into donation_tbl(donation_date,donation_time,donation_amount,donation_method,user_id,donation_status) values (?,?,?,'Online',?,'Pending')",[donation_date,donation_time,donation_amount,user_id],function(err,result){
    if(err) throw err;
    res.redirect('https://pages.razorpay.com/suryabala');
  });
});

router.get('/events_details/:id', function(req, res, next) {
  var id = req.params.id;
  var today = new Date();
  var last_known_donation = req.session.last_blood_donation_date;
  var user_id = req.session.user_id;
                                           
  connection.query("select * from event_tbl where event_id = ? ",[id],function(err,rows1){
    
    connection.query("select * from feedback_tbl where event_id = ? ",[id],function(err,rows2){
      connection.query("select * from ngo_info_tbl",function(err,rows3){
        connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows4){
          connection.query("select count(registration_id) as rc from event_registration_tbl where event_id = ?",[id],function(err,rows5){
            connection.query("select count(is_present) as ca from event_registration_tbl where event_id = ? and is_present = 1",[id],function(err,rows6){
              connection.query("select * from event_registration_tbl where user_id = ? and event_id = ?",[user_id,id],function(err,rows7){
                connection.query("select * from volunteer_tbl where user_id = ? and event_id = ?",[user_id,id],function(err,rows8){
              if(req.session.user_password){
                res.render('users/events_details',{event_info : rows1,feedback_info : rows2,ngo_info : rows3,event:rows4, curdate : today, last_bld : last_known_donation,event_cnt:rows5,present_cnt:rows6, registration_info : rows7, volunteer_info : rows8});
              }
              else{
                res.redirect('/users/login');
              }
              });
            }); 
            });
          });
        });
      });
    });
  });
});

router.post('/events_details_feedback/:id', function(req, res, next) {
  console.log(req.body)
  var id = req.params.id;
  var today = new Date();
  var mdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
  var mtime = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
  
  var feedback_date = mdate;
  var feedback_time = mtime;
  var feedback_description = req.body.feedback_description;
  var usr_id = req.session.user_id;
  connection.query("insert into feedback_tbl(feedback_description,feedback_date,feedback_time,event_id,user_id) values (?,?,?,?,?)",[feedback_description,feedback_date,feedback_time,id,usr_id],function(err,result){
      if(err) throw err;
      res.redirect('/users/events');
  });
});

router.post('/events_details_contributor/:id', function(req, res, next) {
  console.log(req.body)
  var id = req.params.id;
  var today = new Date();
  var mdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
  
  var registration_date = mdate;
  var last_blood_donation_date = req.body.last_known_donation;
  var usr_id = req.session.user_id;
    connection.query("insert into event_registration_tbl(registration_date,event_id,user_id,is_present) values (?,?,?,?)",[registration_date,id,usr_id,0],function(err,result){
        connection.query("update user_master set user_last_date_donation = ? where user_id = ?" ,[last_blood_donation_date, usr_id],function(err,result){
      if(err) throw err;
      res.redirect('/users/events');
      });
  });
});

router.post('/events_details_volunteer/:id', function(req, res, next) {
  console.log(req.body)
  var id = req.params.id;
  var today = new Date();
  var mdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
  
  var registration_date = mdate;
  var usr_id = req.session.user_id;
  connection.query("insert into volunteer_tbl(registration_date,event_id,user_id,is_present) values (?,?,?,?)",[registration_date,id,usr_id,0],function(err,result){
      if(err) throw err;
      res.redirect('/users/events');
        });
  });
  
  router.get('/chng_pass', function(req, res, next) {
  connection.query("select * from ngo_info_tbl",function(err,rows1){
    connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows2){
      if(req.session.user_password)
      {
      res.render("users/chng_pass",{ngo_info : rows1, event:rows2});
      }
      else
      {
        res.redirect("/users/login");
      }
    });
  });
});

router.post('/change_password_process',function(req, res, next){
  
  var user_mobile = req.session.user_mobile;
  var old_password = req.body.old_password;
  var new_password = req.body.new_password;
  var confirm_password = req.body.confirm_password;
  
  //check user is logged on
  if(req.session.user_mobile){
    connection.query("select * from user_master where user_mobile = ?",[user_mobile],function(err,rows){
      if(err){
        res.send('Error');
      }else{
        if(rows.length>0){
          var user_password = rows[0].user_password;
          console.log(user_password);
          //check old password is matched with database
          if(old_password == user_password){
            if (new_password == confirm_password){
              connection.query("update user_master set user_password = ? where user_mobile = ?",[new_password,user_mobile],function(err,rows){
                res.send("Password Change");
              });
            }else{
              res.send("New and confirm password not match");
            }
          }else{
            res.send("Old password does not match");
          }
        }else{
          res.send("No record found");
        }
      }
    });
  }
});

router.get('/forgot_pwd', function(req, res, next) {
  connection.query("select * from ngo_info_tbl",function(err,rows1){
    connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows2){
      res.render('users/forgot_pwd',{ngo_info : rows1, event : rows2});
    });
  });
});

router.post('/forgot_pwd_process', function(req, res, next) {
  var user_email = req.body.user_email;
  console.log( "FP"+ user_email)
  connection.query("select * from user_master where user_email = ? ",[user_email],function(err,rows){
    
      if(rows.length>0)
      {
        var mypassword = rows[0].user_password;
        var msg = `Password is ${mypassword}`
                      "use strict";
              const nodemailer = require("nodemailer");

              // async..await is not allowed in global scope, must use a wrapper
              async function main() {
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
                  to: user_email, // list of receivers
                  subject: "Forgot Password", // Subject line
                  text: msg, // plain text body
                  html:  msg, // html body
                });

                console.log("Message sent: %s", info.messageId);
                // Message sent: <b658f8ca-6296-ccf4-8306-87d57a0b4321@example.com>

                // Preview only available when sending through an Ethereal account
                console.log("Preview URL: %s", nodemailer.getTestMessageUrl(info));
                // Preview URL: https://ethereal.email/message/WaQKMgKddxQDoou...
              }

              main().catch(console.error);

        console.log('Forgot Password' + mypassword);
        //res.redirect('/users/');
        //res.send("Password Sent");

      }
      else
      {
        res.send("User Not Found");
      }
    
  });
});


router.get('/profile_details', function(req, res, next) {
  var user_id = req.session.user_id;
  connection.query("select * from ngo_info_tbl",function(err,rows1){
    connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows2){
      connection.query("select * from user_master INNER JOIN myproject.category_tbl ON (user_master.user_prefered_category = category_tbl.category_id) where user_id = ?",[user_id],function(err,rows3){
        if(req.session.user_password)
        {
          res.render("users/profile_details",{ngo_info : rows1,event:rows2,profile:rows3});
        }
        else
        {
          res.redirect("/users/login");
        }
      });
    });
  });
});



router.get('/history', function(req, res, next){
  var user_id = req.session.user_id;
  console.log(user_id)
  connection.query("select * from ngo_info_tbl",function(err,rows1){
      connection.query(`SELECT event_tbl.event_title, event_tbl.event_date FROM myproject.volunteer_tbl INNER JOIN myproject.event_tbl ON (volunteer_tbl.event_id = event_tbl.event_id) where volunteer_tbl.user_id = ?`,[user_id],function(err,rows2){
      connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows3){
        connection.query(`SELECT event_tbl.event_title, event_tbl.event_date FROM myproject.event_registration_tbl INNER JOIN myproject.event_tbl ON (event_registration_tbl.event_id = event_tbl.event_id) where event_registration_tbl.user_id = ?`,[user_id],function(err,rows4){
          connection.query(`SELECT * FROM donation_tbl WHERE user_id = ?`,[user_id],function(err,rows5){
            if(req.session.user_id){
              res.render("users/history",{ngo_info : rows1, volunteer_info : rows2, event : rows3, evt_info : rows4, donation_info : rows5});
            }
            else
            {
              res.redirect("/users/login");
            }
          });
        });
      });
    });
  });
});

router.get('/edit_profile/:user_id', function(req, res, next) {
  var user_id = req.params.user_id;
  console.log("Edit user id is" + user_id);
  
    connection.query("select * from ngo_info_tbl",function(err,rows1){
      connection.query("select * from event_tbl ORDER BY `event_tbl`.`event_id` DESC",function(err,rows4){
        connection.query("select * from user_master WHERE user_id = ?",[user_id],function(err,db_rows){
          connection.query("select * from location_tbl ",function(err,db_rows3){
            connection.query("select * from category_tbl ",function(err,db_rows5){

        if(req.session.user_password)
        {
          
          res.render("users/edit_profile",{ngo_info : rows1,event:rows4,db_rows_array: db_rows,location:db_rows3,category:db_rows5});
              
        }
        else
        {
          res.redirect("/users/login");
        }
            });
          });
        });
      });
    });
});

router.post('/edit_profile/:user_id', function(req, res, next){
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
        connection.query("update user_master set user_name = ? , user_image  = ?, user_dob = ? , user_gender = ? , user_mobile  = ?, user_email = ?, user_location = ?, user_country_code = ?, user_prefered_category = ?, user_blood_group = ?, user_last_date_donation = ?, user_health_issue = ? where user_id = ?",[user_name,filename,user_dob,user_gender,user_mobile,user_email,user_location,user_country_code,user_prefered_category,user_blood_group,user_last_date_donation,user_health_issue,user_id],function(err){
          if(err) throw err;
          res.redirect('/users/profile_details');
        });
        return console.log("File UPLOADED");
      }
    });  
  }
  else{
    console.log("File must be image and of less than 1mb");
  }
});



module.exports = router;
