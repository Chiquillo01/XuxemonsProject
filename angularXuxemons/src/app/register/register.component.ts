// import { Component } from '@angular/core';

// @Component({
//   selector: 'app-register',
//   templateUrl: './register.component.html',
//   styleUrls: ['./register.component.css']
// })
// export class RegisterComponent {

// }

import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../auth.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent {

  constructor(private authService: AuthService, private router: Router) { }

  register(user: any): void {
    this.authService.register(user).subscribe(
      response => {
        // Redireccionar al usuario a la página de inicio de sesión
        this.router.navigate(['/register']);
      },
      error => {
        // Manejar el error (por ejemplo, mostrar un mensaje de error al usuario)
      }
    );
  }
}
