import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { JurusanPageRoutingModule } from './jurusan-routing.module';

import { JurusanPage } from './jurusan.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    JurusanPageRoutingModule
  ],
  declarations: [JurusanPage]
})
export class JurusanPageModule {}
