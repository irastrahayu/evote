import { Component, Input, OnInit } from '@angular/core';
import { ModalController, ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-edit-kelas-modal',
  templateUrl: './edit-kelas-modal.component.html',
  styleUrls: ['./edit-kelas-modal.component.scss'],
})
export class EditKelasModalComponent implements OnInit {
  @Input() data: any;
  form: any = {};
  jurusans: any = [];

  constructor(
    private modalController: ModalController,
    private toastController: ToastController
  ) { }

  ngOnInit() {
    this.form.nama = this.data.nama;
    this.form.id_jurusan = this.data.id_jurusan;

    this.getAllJurusan();
  }

  close() {
    this.modalController.dismiss();
  }

  async update() {
    try {
      const res = await fetch(`${environment.BASE_URL}admin/kelas/${this.data.id}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify(this.form)
      });

      const json = await res.json();
      if (res.status !== 201) {
        return this.toastController.create({
          message: json.message,
          duration: 2000,
          color: 'danger'
        }).then(toast => toast.present());
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
