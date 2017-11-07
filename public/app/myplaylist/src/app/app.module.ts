import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { Routes, RouterModule } from '@angular/router'
import { Location } from '@angular/common';

const routesConfig: Routes = [
   { path: 'login', component: LoginComponent },
   { path: 'register', component: RegisterComponent}
];

import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegisterComponent   
  ],
  imports: [
    BrowserModule,
    HttpModule,
    FormsModule,
    RouterModule.forRoot(routesConfig),
  ],
  providers: [Location],
  bootstrap: [AppComponent]
})
export class AppModule { }
