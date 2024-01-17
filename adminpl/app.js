var createError = require('http-errors');
var express = require('express');
var path = require('path');
var cookieParser = require('cookie-parser');
var logger = require('morgan');
var session = require('express-session')
const fileUpload = require('express-fileupload');
var moment = require('moment');


var indexRouter = require('./routes/index');
var usersRouter = require('./routes/users');

var app = express();

// Access the session as req.session
/*app.get('/loginsession', function(req, res, next) {
  if (req.session.views) {
    req.session.views++
    res.setHeader('Content-Type', 'text/html')
    res.write('<p>views: ' + req.session.views + '</p>')
    res.write('<p>expires in: ' + (req.session.cookie.maxAge / 1000) + 's</p>')
    res.end()
  } else {
    req.session.views = 1
    res.end('welcome to the session demo. refresh!')
    res.redirect('/admin_home')
  }
})*/


// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));
// Use the session middleware
app.use(session({ secret: 'keyboard cat', cookie: {maxAge:6000000}}))
app.use(fileUpload());

app.use(function(req,res,next){
  res.locals.user_id=req.session.user_id;
  res.locals.user_mobile=req.session.user_mobile;
  res.locals.user_name=req.session.user_name;
  res.locals.user_image=req.session.user_image;
  res.locals.type_id=req.session.type_id;
  next();
});


app.use('/', indexRouter);
app.use('/users/', usersRouter);

// catch 404 and forward to error handler
app.use(function(req, res, next) {
  next(createError(404));
});

// error handler
app.use(function(err, req, res, next) {
  // set locals, only providing error in development
  
  res.locals.message = err.message;
  res.locals.error = req.app.get('env') === 'development' ? err : {};
  app.locals.moment = require('moment');

  // render the error page
  res.status(err.status || 500);
  res.render('error');
});

module.exports = app;

