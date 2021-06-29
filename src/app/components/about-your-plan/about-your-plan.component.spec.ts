import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AboutYourPlanComponent } from './about-your-plan.component';

describe('AboutYourPlanComponent', () => {
  let component: AboutYourPlanComponent;
  let fixture: ComponentFixture<AboutYourPlanComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AboutYourPlanComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AboutYourPlanComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
