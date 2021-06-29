import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HttpClientModule } from '@angular/common/http';
import { SharedModule } from './shared/shared.module';
import { LeftpanelComponent } from './components/leftpanel/leftpanel.component';
import { HomeComponent } from './components/home/home.component';
import { AboutYourPlanComponent } from './components/about-your-plan/about-your-plan.component';
import { WhatIsCoveredComponent } from './components/what-is-covered/what-is-covered.component';
@NgModule({
  declarations: [
    AppComponent,
    LeftpanelComponent,
    HomeComponent,
    AboutYourPlanComponent,
    WhatIsCoveredComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    HttpClientModule,
    SharedModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
