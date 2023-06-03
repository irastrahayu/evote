import { environment } from './../../../environments/environment.prod';
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { LoadingController, ToastController, ModalController, AlertController } from '@ionic/angular';

import { register } from 'swiper/element/bundle';
import { AddKandidatModalComponent } from '../modals/add-kandidat-modal/add-kandidat-modal.component';
import { EditKandidatModalComponent } from '../modals/edit-kandidat-modal/edit-kandidat-modal.component';

register();
@Component({
  selector: 'app-kandidat',
  templateUrl: './kandidat.page.html',
  styleUrls: ['./kandidat.page.scss'],
})
export class KandidatPage implements OnInit {
  data: any = [];
  constructor(
    private loadingController: LoadingController,
    private toastController: ToastController,
    private route: ActivatedRoute,
    private modalController: ModalController,
    private alertController: AlertController
  ) {
    route.params.subscribe(() => {
      this.getAllPemilihan();
    });
  }

  ngOnInit(): void {

  }

  async getAllPemilihan() {
    const loading = await this.loadingController.create({
      message: 'Loading...'
    });

    await loading.present();
    try {
      const res = await fetch(`${environment.BASE_URL}admin/pemilihan`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      });

      const json = await res.json();
      this.data = json.data;

      await loading.dismiss();
    } catch (error) {
      this.toastController.create({
        message: 'Error',
        duration: 2000,
        color: 'danger'
      }).then(toast => {
        toast.present();
        loading.dismiss();
      });
    }
  }

  async eventDetails(data: any) {

  }

  async addKandidat(data: any) {
    this.modalController.create({
      component: AddKandidatModalComponent,
      componentProps: {
        data: data
      }
    }).then(modal => {
      modal.present();
      modal.onDidDismiss().then(() => {
        this.getAllPemilihan();
      });
    });
  }

  async deleteKandidat(data: any) {
    this.alertController.create({
      header: 'Delete Kandidat',
      message: 'Are you sure you want to delete this kandidat?',
      buttons: [
        {
          text: 'Cancel',
          role: 'cancel'
        },
        {
          text: 'Delete',
          handler: async () => {
            try {
              const res = await fetch(`${environment.BASE_URL}admin/kandidat/${data.id}`, {
                method: 'DELETE',
                headers: {
                  'Content-Type': 'application/json',
                  'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
              });

              const json = await res.json();
              this.toastController.create({
                message: json.message,
                duration: 2000,
                color: 'success'
              }).then(toast => {
                toast.present();
                this.getAllPemilihan();
              });
            } catch (err: any) {
              this.toastController.create({
                message: err.message,
                duration: 2000,
              }).then(toast => {
                toast.present();
              });
            }
          }
        }
      ]

    }).then(alert => {
      alert.present();
    });
  }

  async editKandidat(data: any) {
    this.modalController.create({
      component: EditKandidatModalComponent,
      componentProps: {
        data: data
      }
    }).then(modal => {
      modal.present();
      modal.onDidDismiss().then(() => {
        this.getAllPemilihan();
      });
    });
  }
}
