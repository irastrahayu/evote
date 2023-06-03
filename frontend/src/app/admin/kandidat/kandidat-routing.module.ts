import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { KandidatPage } from './kandidat.page';

const routes: Routes = [
  {
    path: '',
    component: KandidatPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class KandidatPageRoutingModule {}
