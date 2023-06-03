import { ComponentFixture, TestBed } from '@angular/core/testing';
import { KandidatPage } from './kandidat.page';

describe('KandidatPage', () => {
  let component: KandidatPage;
  let fixture: ComponentFixture<KandidatPage>;

  beforeEach(async(() => {
    fixture = TestBed.createComponent(KandidatPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
