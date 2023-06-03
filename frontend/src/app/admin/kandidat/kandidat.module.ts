import { CUSTOM_ELEMENTS_SCHEMA, NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { IonicModule } from '@ionic/angular';
import { KandidatPageRoutingModule } from './kandidat-routing.module';
import { KandidatPage } from './kandidat.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    KandidatPageRoutingModule
  ],
  declarations: [KandidatPage],
  schemas: [CUSTOM_ELEMENTS_SCHEMA]

})
export class KandidatPageModule { }
