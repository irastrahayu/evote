import { ComponentFixture, TestBed } from '@angular/core/testing';
import { PemilihanPage } from './pemilihan.page';

describe('PemilihanPage', () => {
  let component: PemilihanPage;
  let fixture: ComponentFixture<PemilihanPage>;

  beforeEach(async(() => {
    fixture = TestBed.createComponent(PemilihanPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
