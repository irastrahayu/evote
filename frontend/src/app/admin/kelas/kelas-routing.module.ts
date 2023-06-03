import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { KelasPage } from './kelas.page';

const routes: Routes = [
  {
    path: '',
    component: KelasPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class KelasPageRoutingModule {}
