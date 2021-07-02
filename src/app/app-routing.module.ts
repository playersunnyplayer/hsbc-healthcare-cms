import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AboutYourPlanComponent } from './components/about-your-plan/about-your-plan.component';
import { ContactUsComponent } from './components/contact-us/contact-us.component';
import { HomeComponent } from './components/home/home.component';
import { MakingAClaimComponent } from './components/making-a-claim/making-a-claim.component';
import { PolicyChangesComponent } from './components/policy-changes/policy-changes.component';
import { WhatIsCoveredComponent } from './components/what-is-covered/what-is-covered.component';

const routes: Routes = [
  { path: 'home', component: HomeComponent },
  { path: 'about-your-plan', component: AboutYourPlanComponent },
  { path: 'what-is-covered', component: WhatIsCoveredComponent },
  { path: 'making-a-claim', component: MakingAClaimComponent },
  { path: 'contact-us', component: ContactUsComponent },
  { path: 'policy-changes', component: PolicyChangesComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes, {
    useHash: true,
    scrollPositionRestoration: 'enabled',
    anchorScrolling: 'enabled'
  })],
  exports: [RouterModule]
})
export class AppRoutingModule { }
