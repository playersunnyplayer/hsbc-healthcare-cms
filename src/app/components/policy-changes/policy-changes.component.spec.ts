import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PolicyChangesComponent } from './policy-changes.component';

describe('PolicyChangesComponent', () => {
  let component: PolicyChangesComponent;
  let fixture: ComponentFixture<PolicyChangesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PolicyChangesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PolicyChangesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
