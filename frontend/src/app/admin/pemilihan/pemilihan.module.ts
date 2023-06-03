import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { PemilihanPageRoutingModule } from './pemilihan-routing.module';

import { PemilihanPage } from './pemilihan.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    PemilihanPageRoutingModule
  ],
  declarations: [PemilihanPage]
})
export class PemilihanPageModule {}
