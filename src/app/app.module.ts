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
import { FormsModule } from '@angular/forms';
import { NgxScrollspyModule } from '@uniprank/ngx-scrollspy';
import { ScrollSpyDirective } from './scroll-spy.directive';
import { LoremIpsumComponent } from './lorem-ipsum.component';
import { MakingAClaimComponent } from './components/making-a-claim/making-a-claim.component';
import { ContactUsComponent } from './components/contact-us/contact-us.component';
import { PolicyChangesComponent } from './components/policy-changes/policy-changes.component';
@NgModule({
  declarations: [
    AppComponent,
    LeftpanelComponent,
    HomeComponent,
    AboutYourPlanComponent,
    WhatIsCoveredComponent,
    ScrollSpyDirective,
    LoremIpsumComponent,
    MakingAClaimComponent,
    ContactUsComponent,
    PolicyChangesComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    HttpClientModule,
    SharedModule,
    FormsModule,
    NgxScrollspyModule.forRoot({ lookAhead: true })
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
