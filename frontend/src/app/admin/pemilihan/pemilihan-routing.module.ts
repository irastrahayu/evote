import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { PemilihanPage } from './pemilihan.page';

const routes: Routes = [
  {
    path: '',
    component: PemilihanPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PemilihanPageRoutingModule {}
