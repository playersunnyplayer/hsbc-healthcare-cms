import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-policy-changes',
  templateUrl: './policy-changes.component.html',
  styleUrls: ['./policy-changes.component.scss']
})
export class PolicyChangesComponent {
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