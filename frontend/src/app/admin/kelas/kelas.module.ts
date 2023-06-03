import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { KelasPageRoutingModule } from './kelas-routing.module';

import { KelasPage } from './kelas.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    KelasPageRoutingModule
  ],
  declarations: [KelasPage]
})
export class KelasPageModule {}
