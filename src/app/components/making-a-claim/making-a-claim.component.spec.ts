import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MakingAClaimComponent } from './making-a-claim.component';

describe('MakingAClaimComponent', () => {
  let component: MakingAClaimComponent;
  let fixture: ComponentFixture<MakingAClaimComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MakingAClaimComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(MakingAClaimComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
