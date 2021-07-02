import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-what-is-covered',
  templateUrl: './what-is-covered.component.html',
  styleUrls: ['./what-is-covered.component.scss']
})
export class WhatIsCoveredComponent {
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
