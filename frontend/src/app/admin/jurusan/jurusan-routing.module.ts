import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { JurusanPage } from './jurusan.page';

const routes: Routes = [
  {
    path: '',
    component: JurusanPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class JurusanPageRoutingModule {}
