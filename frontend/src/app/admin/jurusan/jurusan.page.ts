import { Component, OnInit } from '@angular/core';
import { AlertController, ModalController, ToastController } from '@ionic/angular';
import { AddJurusanModalComponent } from '../modals/add-jurusan-modal/add-jurusan-modal.component';
import { environment } from 'src/environments/environment';
import { EditJurusanModalComponent } from '../modals/edit-jurusan-modal/edit-jurusan-modal.component';

@Component({
  selector: 'app-jurusan',
  templateUrl: './jurusan.page.html',
  styleUrls: ['./jurusan.page.scss'],
})
export class JurusanPage implements OnInit {
  jurusans: any = [];

  constructor(
    private modalController: ModalController,
    private toastController: ToastController,
    private alertController: AlertController
  ) { }

  ngOnInit() {
    this.getAllJurusan();
  }

  addJurusan() {
    this.modalController.create({
      component: AddJurusanModalComponent,
    }).then(modal => {
      modal.present();
      modal.onDidDismiss().then(() => {
        this.getAllJurusan();
      });
    });
  }

  editJurusan(data: any) {
    this.modalController.create({
      component: EditJurusanModalComponent,
      componentProps: {
        data
      }
    }).then(modal => {
      modal.present();
      modal.onDidDismiss().then(() => {
        this.getAllJurusan();
      });
    });
  }

  deleteJurusan(id: any) {
    this.alertController.create({
      header: 'Konfirmasi',
      message: 'Apakah anda yakin ingin menghapus jurusan ini?',
      buttons: [
        {
          text: 'Batal',
          role: 'cancel'
        },
        {
          text: 'Hapus',
          handler: () => {
            this.delete(id);
          }
        }
      ]
    }).then(alert => {
      alert.present();
    });
  }

  async delete(id: any) {
    try {
      const res = await fetch(`${environment.BASE_URL}admin/jurusan/${id}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      });

      const json = await res.json();
      if (res.status !== 201) {
        this.toastController.create({
          message: json.message,
          duration: 2000,
          color: 'danger'
        }).then(toast => toast.present());
        return;
      }

      this.toastController.create({
        message: json.message,
        duration: 2000,
        color: 'success'
      }).then(toast => {
        toast.present();
        this.getAllJurusan();
      });
    } catch (err) {
      console.log(err);
    }
  }

  async getAllJurusan() {
    try {
      const res = await fetch(`${environment.BASE_URL}admin/jurusan`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      });

      const json = await res.json();
      if (res.status !== 200) {
        this.toastController.create({
          message: json.message,
          duration: 2000
        }).then(toast => toast.present());
        return;
      }

      this.jurusans = json.data;
    } catch (err) {
      console.log(err);
    }
  }
}
