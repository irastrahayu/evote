import { environment } from './../../../../environments/environment';
import { Component, OnInit } from '@angular/core';
import { ToastController, ModalController } from '@ionic/angular';

@Component({
  selector: 'app-add-user-modal',
  templateUrl: './add-user-modal.component.html',
  styleUrls: ['./add-user-modal.component.scss'],
})
export class AddUserModalComponent implements OnInit {
  aKelas: any = [];
  form: any = {}
  role: any;
  constructor(
    private toastController: ToastController,
    private modalController: ModalController
  ) { }

  ngOnInit() {
    this.getAllKelas();
  }

  async create() {
    try {
      let body: any = {};
      switch (this.role) {
        case 'user':
          body.name = this.form.name;
          body.nis = this.form.nis;
          body.email = this.form.email;
          body.id_kelas = this.form.id_kelas;
          body.password = this.form.password;
          body.role = this.role;
          break;

        case 'admin':
          body.name = this.form.name;
          body.email = this.form.email;
          body.password = this.form.password;
          body.role = this.role;
      }

      const res = await fetch(`${environment.BASE_URL}admin/user`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify(body)
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
      }

      this.toastController.create({
        message: json.message,
        duration: 2000,
        color: 'success'
      }).then(toast => {
        toast.present();
        this.modalController.dismiss();
      });
    } catch (err) {
      console.log(err);
    }
  }

  close() {
    this.modalController.dismiss();
  }

  async getAllKelas() {
    try {
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
      }

      this.aKelas = json.data;
    } catch (err) {
      console.log(err);
    }
  }


  changeRole(event: any) {
    this.role = event.detail.value;
  }
}
