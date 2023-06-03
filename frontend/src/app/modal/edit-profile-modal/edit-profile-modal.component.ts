import { AlertController, LoadingController, ModalController, ToastController } from '@ionic/angular';
import { Component, Input, OnInit } from '@angular/core';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-edit-profile-modal',
  templateUrl: './edit-profile-modal.component.html',
  styleUrls: ['./edit-profile-modal.component.scss'],
})
export class EditProfileModalComponent implements OnInit {
  @Input() user: any;
  form: any = {};
  classes: any = [];

  constructor(
    private modalController: ModalController,
    private loadingController: LoadingController,
    private alertController: AlertController,
    private toastController: ToastController
  ) { }

  ngOnInit() {
    this.getAllClass();
  }

  async getAllClass() {
    const loading = await this.loadingController.create({
      message: 'Loading...'
    });

    await loading.present();
    try {
      const res = await fetch(`${environment.BASE_URL}kelas`, {
        headers: {
          'Content-Type': 'application/json'
        }
      });

      const json = await res.json();
      if (res.status !== 200) {
        this.alertController.create({
          header: 'Error',
          message: json.message,
          buttons: ['OK']
        }).then(alert => alert.present());
      }

      this.classes = json.data;
    } catch (err: any) {
      this.alertController.create({
        header: 'Error',
        message: err.message,
        buttons: ['OK']
      }).then(alert => alert.present());
    } finally {
      loading.dismiss();
    }
  }

  async update() {
    this.form.nis = this.user.nis;
    this.form.nama = this.user.name;
    this.form.email = this.user.email;
    this.form.id_kelas = this.user.id_kelas;
    this.form.password = this.user.password;

    if (!this.form.password) delete this.form.password;
    try {
      const res = await fetch(`${environment.BASE_URL}profile`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify(this.form)
      });

      const json = await res.json();
      if (res.status !== 200) {
        this.toastController.create({
          message: json.message,
          duration: 2000,
          color: 'danger'
        }).then(toast => toast.present());

        return;
      }

      this.toastController.create({
        message: 'Berhasil mengubah data!',
        duration: 2000,
        color: 'success'
      }).then(toast => toast.present());

      this.modalController.dismiss();
    } catch (err: any) {

    }
  }

  close() {
    this.modalController.dismiss();
  }
}
