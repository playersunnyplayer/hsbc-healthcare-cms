import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AboutYourPlanComponent } from './components/about-your-plan/about-your-plan.component';
import { HomeComponent } from './components/home/home.component';
import { WhatIsCoveredComponent } from './components/what-is-covered/what-is-covered.component';

const routes: Routes = [
  { path: 'home', component: HomeComponent },
  { path: 'what-is-covered', component: WhatIsCoveredComponent },
  { path: 'about-your-plan', component: AboutYourPlanComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
