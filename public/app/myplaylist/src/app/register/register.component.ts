import { Component, OnInit } from '@angular/core';
import { NgModel } from '@angular/forms';
import { RegisterService } from './register.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
  providers: [RegisterService]
})
export class RegisterComponent implements OnInit {
  constructor(private registerService: RegisterService) { }
  ngOnInit() {
  }

  username = "";
  password = "";
  repassword = "";
  messager = "";
  messagerRePass = ""; 
  register() {
    if(this.username.trim()=="")
    {
      this.messager = "Please input username";
      return;
    }
    if(this.password.trim()=="")
    {
      this.messager = "Please input password";
      return;
    }
    if(this.repassword.trim()=="")
    {
      this.messager = "Please input repassword";
      return;
    }
    var user = { username: this.username, password: this.password };
    this.registerService.checkUserExists(user).then(result => {     
      if(result.isexists=="isexists")
      {       
        this.messager = "User is exists!" ;
      }
      else
      {
        this.messager = "";
        var body = { username: this.username, password: this.password };         
        this.registerService.postRegister(body).then(result => {
          this.messager = result.messager;          
        });
      }
    });

  }

  reset() {
    this.username = "";
    this.password = "";
    this.repassword = "";
    this.messager = "";
    this.messagerRePass = "";
  }

  checkPassLeng() {
    if(this.password!=this.repassword&&this.repassword!="")
      this.messagerRePass = "password incorrect";
    else
      this.messagerRePass = "";
  }
}
