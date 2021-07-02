import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-making-a-claim',
  templateUrl: './making-a-claim.component.html',
  styleUrls: ['./making-a-claim.component.scss']
})
export class MakingAClaimComponent {
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
