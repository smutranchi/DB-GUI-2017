import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { Routes, RouterModule } from '@angular/router';
import { Location } from '@angular/common';

// internal module

// internal components
import { AppComponent } from './app.component';
import { RegisterComponent } from './account/register/register.component';
import { LoginComponent } from './account/login/login.component';
import { LogoutComponent } from './account/logout/logout.component';
import { ViewPlaylistComponent } from './module/view-playlist/view-playlist.component';
import { AddPlaylistComponent } from './module/add-playlist/add-playlist.component';
import { AddVideoComponent } from './module/add-video/add-video.component';
import { ViewVideoComponent } from './module/view-video/view-video.component';

const routes: Routes = [
  { path: 'register', component: RegisterComponent },
  { path: 'login', component: LoginComponent },
  { path: 'logout', component: LogoutComponent }
];

@NgModule({
  declarations: [
    AppComponent,
    RegisterComponent,
    LoginComponent,
    LogoutComponent,
    ViewPlaylistComponent,
    AddPlaylistComponent,
    AddVideoComponent,
    ViewVideoComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    RouterModule.forRoot(routes)
  ],
  providers: [Location],
  bootstrap: [AppComponent]
})
export class AppModule { }
