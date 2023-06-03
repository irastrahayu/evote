import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { RouteReuseStrategy } from '@angular/router';

import { IonicModule, IonicRouteStrategy } from '@ionic/angular';

import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';
import { AboutPageModule } from './about/about.module';
import { SupportPageModule } from './support/support.module';
import { EventDetailsPageModule } from './event-details/event-details.module';
import { EditProfileModalComponent } from './modal/edit-profile-modal/edit-profile-modal.component';
import { FormsModule } from '@angular/forms';
import { KandidatDetailModalComponent } from './modal/kandidat-detail-modal/kandidat-detail-modal.component';
import { TabsComponent } from './admin/tabs/tabs.component';
import { EditPemilihanModalComponent } from './admin/modals/edit-pemilihan-modal/edit-pemilihan-modal.component';
import { AddPemilihanModalComponent } from './admin/modals/add-pemilihan-modal/add-pemilihan-modal.component';
import { AddKandidatModalComponent } from './admin/modals/add-kandidat-modal/add-kandidat-modal.component';
import { EditKandidatModalComponent } from './admin/modals/edit-kandidat-modal/edit-kandidat-modal.component';
import { AddUserModalComponent } from './admin/modals/add-user-modal/add-user-modal.component';
import { EditUserModalComponent } from './admin/modals/edit-user-modal/edit-user-modal.component';
import { AddKelasModelComponent } from './admin/modals/add-kelas-model/add-kelas-model.component';
import { EditKelasModalComponent } from './admin/modals/edit-kelas-modal/edit-kelas-modal.component';
import { AddJurusanModalComponent } from './admin/modals/add-jurusan-modal/add-jurusan-modal.component';
import { EditJurusanModalComponent } from './admin/modals/edit-jurusan-modal/edit-jurusan-modal.component';

@NgModule({
  declarations: [
    AppComponent, EditProfileModalComponent, KandidatDetailModalComponent, TabsComponent, EditPemilihanModalComponent,
    AddPemilihanModalComponent, AddKandidatModalComponent, EditKandidatModalComponent, AddUserModalComponent, EditUserModalComponent,
    AddKelasModelComponent, EditKelasModalComponent, AddJurusanModalComponent, EditJurusanModalComponent
  ],
  imports: [BrowserModule, IonicModule.forRoot(), AppRoutingModule, AboutPageModule, SupportPageModule, EventDetailsPageModule, FormsModule],
  providers: [{ provide: RouteReuseStrategy, useClass: IonicRouteStrategy }],
  bootstrap: [AppComponent],
})
export class AppModule { }
