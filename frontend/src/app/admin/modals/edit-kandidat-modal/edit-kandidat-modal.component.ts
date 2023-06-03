import { Component, Input, OnInit } from '@angular/core';
import { ModalController, ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-edit-kandidat-modal',
  templateUrl: './edit-kandidat-modal.component.html',
  styleUrls: ['./edit-kandidat-modal.component.scss'],
})
export class EditKandidatModalComponent implements OnInit {
  @Input() data: any;
  form: any = {};
  aKelas: any = [];
  constructor(
    private toastController: ToastController,
    private modalController: ModalController
  ) { }

  ngOnInit() {
    this.getAllKelas();

    this.form.nama_ketua = this.data.nama_ketua;
    this.form.nama_wakil = this.data.nama_wakil;
    this.form.id_kelas_ketua = this.data.id_kelas_ketua;
    this.form.id_kelas_wakil = this.data.id_kelas_wakil;
    this.form.visi = this.data.visi;
    this.form.misi = this.data.misi;
  }

  uploadFile(event: any) {
    this.form.image = event.target.files[0];
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

  async edit() {
    try {
      const formData = new FormData();
      formData.append('nama_ketua', this.form.nama_ketua);
      formData.append('nama_wakil', this.form.nama_wakil);
      formData.append('id_kelas_ketua', this.form.id_kelas_ketua);
      formData.append('id_kelas_wakil', this.form.id_kelas_wakil);
      formData.append('visi', this.form.visi);
      formData.append('misi', this.form.misi);
      formData.append('id_pemilihan', this.data.id_pemilihan);
      formData.append('__method', 'PUT');
      if (this.form.image) {
        formData.append('image', this.form.image);
      }

      const res = await fetch(`${environment.BASE_URL}admin/kandidat/${this.data.id}`, {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: formData
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
}
