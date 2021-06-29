import { ComponentFixture, TestBed } from '@angular/core/testing';

import { WhatIsCoveredComponent } from './what-is-covered.component';

describe('WhatIsCoveredComponent', () => {
  let component: WhatIsCoveredComponent;
  let fixture: ComponentFixture<WhatIsCoveredComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ WhatIsCoveredComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(WhatIsCoveredComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
