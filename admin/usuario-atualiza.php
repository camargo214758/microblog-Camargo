<?php 
require "../inc/funcoes-usuarios.php";
require "../inc/cabecalho-admin.php";
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$usuario = lerUmUsuario($conexao, $id);

if(isset($_POST['atualizar'])){
  $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
  $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);

  /* Logica para a senha
  Se o campo da senha do formulario estiver vasio,
  então significa que o usuario NAO MUDOU A SENHA. */
  if( empty($_POST['senha'])){
    $senha = $usuario['senha']; // manter a senha já existente no banco
    }else{

      
      /*
    
      Caso contrário, se o usuario digitou coisa no campo senha, precisaremos verificar a senha. */
      $senha = verificaSenha($_POST['senha'], $usuario['senha']);
    }

    /* teste senhas 
    echo $usuario['senha'];
    echo "<br>";
    echo "formulario:" .$senha;*/

    atualizarUsuario($conexao, $id, $nome, $email, $senha, $tipo);
    header("location:usuarios.php");
  }
?>
      
<div class="row">
  <article class="col-12 bg-white rounded shadow my-1 py-4">
    <h2 class="text-center">Atualizar Usuário</h2>

    <form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar">

      <div class="form-group">
        <label for="nome">Nome:</label>
        <input value="<?=$usuario['nome']?>" class="form-control" required type="text" id="nome" name="nome">
      </div>

      <div class="form-group">
        <label for="email">E-mail:</label>
        <input value="<?=$usuario['email']?>" class="form-control" required type="email" id="email" name="email">
      </div>

      <div class="form-group">
        <label for="nova-senha">Senha</label>
        <input class="form-control" type="password" id="senha" name="senha" placeholder="Preencha apenas se for alterar">
      </div>

      <div class="form-group">
        <label for="tipo">Tipo:</label>
        <select class="custom-select" name="tipo" id="tipo" required>
          <option value=""></option>                  
          <option
          <?php if($usuario['tipo'] == 'editor') echo " selected " ?>
          value="editor">Editor</option>     
          <option	
          <?php if($usuario['tipo'] == 'admin') echo " selected " ?>
          value="admin">Administrador</option>
        </select>
      </div>
      
      <button class="btn btn-primary" name="atualizar">Atualizar usuário</button>
    </form>
      
  </article>
</div>

<?php
require "../inc/rodape-admin.php"; 
?>