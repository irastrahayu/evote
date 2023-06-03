import { Component, ComponentRef, OnInit } from '@angular/core';
import { ActivatedRoute, Route, Router } from '@angular/router';
import { AlertController, LoadingController, ModalController, ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';
import { EditPemilihanModalComponent } from '../modals/edit-pemilihan-modal/edit-pemilihan-modal.component';
import { AddPemilihanModalComponent } from '../modals/add-pemilihan-modal/add-pemilihan-modal.component';

@Component({
  selector: 'app-pemilihan',
  templateUrl: './pemilihan.page.html',
  styleUrls: ['./pemilihan.page.scss'],
})
export class PemilihanPage implements OnInit {
  data: any;
  componentRef!: ComponentRef<PemilihanPage>;

  constructor(
    private loadingController: LoadingController,
    private router: Router,
    private toastController: ToastController,
    private modalController: ModalController,
    private alertController: AlertController,
    private route: ActivatedRoute
  ) {
    route.params.subscribe(() => {
      this.getAllPemilihan();
    });
  }

  async ngOnInit() {
    const loading = await this.loadingController.create({
      message: 'Loading...'
    });
    await loading.present();

    try {
      this.getAllPemilihan();
    } catch (error) {
      loading.dismiss();
    } finally {
      await loading.dismiss();
    }
  }

  async getAllPemilihan() {
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
    } catch (error) {
      this.toastController.create({
        message: 'Error',
        duration: 2000,
        color: 'danger'
      }).then(toast => {
        toast.present();
      });
    }
  }

  async editEvent(data: any) {
    this.modalController.create({
      component: EditPemilihanModalComponent,
      componentProps: {
        data
      }
    }).then(modal => {
      modal.present();
      modal.onDidDismiss().then(() => {
        this.getAllPemilihan();
      });
    });
  }

  async addEvent() {
    this.modalController.create({
      component: AddPemilihanModalComponent,
    }).then(modal => {
      modal.present();
      modal.onDidDismiss().then(() => {
        this.getAllPemilihan();
      });
    });
  }

  deleteEvent(data: any) {
    this.alertController.create({
      header: 'Delete',
      message: 'Apakah kamu yakin ingin menghapus pemilihan ini? Data Kandidat dan Voting yang berkaitan dengan pemilihan ini juga akan terhapus.',
      buttons: [
        {
          text: 'Cancel',
          role: 'cancel'
        },
        {
          text: 'Delete',
          handler: async () => {
            this.removeEvent(data);
          }
        }
      ]
    }).then(alert => {
      alert.present();
    });
  }

  async removeEvent(data: any) {
    try {
      const res = await fetch(`${environment.BASE_URL}admin/pemilihan/${data}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      });

      const json = await res.json();
      if (res.status !== 200) {
        this.toastController.create({
          message: json.message,
          duration: 2000,
          color: 'danger'
        }).then(toast => {
          toast.present();
        });

        return;
      }

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
        color: 'danger'
      }).then(toast => {
        toast.present();
      });
    }
  }
}
