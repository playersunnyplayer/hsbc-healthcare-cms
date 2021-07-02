import { Component, OnInit } from '@angular/core';
import { ScrollSpyService } from '@uniprank/ngx-scrollspy';

@Component({
  selector: 'app-about-your-plan',
  templateUrl: './about-your-plan.component.html',
  styleUrls: ['./about-your-plan.component.scss']
})
export class AboutYourPlanComponent {
  currentSection = 'section1';

  onSectionChange(sectionId: any) {
    this.currentSection = sectionId;
    console.log(sectionId)
  }

  scrollTo(section: any) {
    if(document) {
      document.querySelector('#' + section)!.scrollIntoView();
    }
  }
}
