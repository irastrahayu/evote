import { ComponentFixture, TestBed } from '@angular/core/testing';
import { JurusanPage } from './jurusan.page';

describe('JurusanPage', () => {
  let component: JurusanPage;
  let fixture: ComponentFixture<JurusanPage>;

  beforeEach(async(() => {
    fixture = TestBed.createComponent(JurusanPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
