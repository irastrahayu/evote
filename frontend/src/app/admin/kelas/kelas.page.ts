import { Component, OnInit } from '@angular/core';
import { AlertController, ModalController, ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';
import { AddKandidatModalComponent } from '../modals/add-kandidat-modal/add-kandidat-modal.component';
import { AddKelasModelComponent } from '../modals/add-kelas-model/add-kelas-model.component';
import { EditKelasModalComponent } from '../modals/edit-kelas-modal/edit-kelas-modal.component';

@Component({
  selector: 'app-kelas',
  templateUrl: './kelas.page.html',
  styleUrls: ['./kelas.page.scss'],
})
export class KelasPage implements OnInit {
  classes: any = [];

  constructor(
    private toastController: ToastController,
    private modalController: ModalController,
    private alertController: AlertController
  ) { }

  ngOnInit() {
    this.getAllKelas();
  }

  addKelas() {
    this.modalController.create({
      component: AddKelasModelComponent,
    }).then(modal => {
      modal.present();
      modal.onDidDismiss().then(() => {
        this.getAllKelas();
      });
    });
  }

  editClass(data: any) {
    this.modalController.create({
      component: EditKelasModalComponent,
      componentProps: {
        data
      }
    }).then(modal => {
      modal.present();
      modal.onDidDismiss().then(() => {
        this.getAllKelas();
      });
    });
  }

  async deleteClass(id: any) {
    try {
      this.alertController.create({
        header: 'Konfirmasi',
        message: 'Apakah anda yakin ingin menghapus kelas ini?',
        buttons: [
          {
            text: 'Batal',
            role: 'cancel'
          },
          {
            text: 'Hapus',
            handler: async () => {
              this.delete(id);
            }
          }
        ]
      }).then(alert => {
        alert.present();
      });
    } catch (err) {
      console.log(err);
    }
  }

  async delete(id: any) {
    try {
      const res = await fetch(`${environment.BASE_URL}admin/kelas/${id}`, {
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
        }).then(toast => {
          toast.present();
        });
        return;
      }

      this.toastController.create({
        message: json.message,
        duration: 2000,
      }).then(toast => {
        toast.present();
        this.getAllKelas();
      });
    } catch (err) {
      console.log(err);
    }
  }

  async getAllKelas() {
    const res = await fetch(`${environment.BASE_URL}admin/kelas`, {
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
        duration: 2000,
        color: 'danger'
      }).then(toast => {
        toast.present();
      });

      return;
    }

    this.classes = json.data;
  }
}
