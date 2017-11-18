import { Component, OnInit } from '@angular/core';
import { LoginService } from './login.service';
import { NgModel  } from '@angular/forms';
import { Router } from '@angular/router';
import {Location, LocationStrategy, PathLocationStrategy} from '@angular/common';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
  providers: [LoginService, Location, {provide: LocationStrategy, useClass: PathLocationStrategy}]
})
export class LoginComponent implements OnInit {

  constructor(private loginService: LoginService, private location: Location) {}

  ngOnInit() {
  }
  username = "";
  password = "";
  messager = "";  
  login_click() {
    if(this.username.trim()=="")
    {
      this.messager = "Please input username!";
      return;
    }
    if(this.password.trim()=="")
    {
      this.messager = "Please input password!";
      return;
    }
    var body = { username: this.username, password: this.password };   
    var url = ""  ;
    this.loginService.postLogin(body).then(result => {
      if(result.url=="")
      {      
        this.messager = result.messager;
      }   
      else
      {     
         console.log("redirect");
         location.href = result.url;
      }
     });
  }
}
