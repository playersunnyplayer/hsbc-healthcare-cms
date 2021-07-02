import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-contact-us',
  templateUrl: './contact-us.component.html',
  styleUrls: ['./contact-us.component.scss']
})
export class ContactUsComponent {
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
