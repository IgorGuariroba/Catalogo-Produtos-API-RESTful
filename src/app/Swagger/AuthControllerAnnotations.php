<?php

namespace App\Swagger;

/**
 * @OA\Tag(
 *      name="Auth",
 *      description="API Entripoint da API para autenticação e registro de usuários.",
 * )
 */
class AuthControllerAnnotations
{
    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Auth"},
     *     summary="Login do usuário",
     *     description="Realiza o login do usuário e retorna um token JWT se as credenciais forem válidas.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="senha")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login bem-sucedido",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="user@example.com")
     *             ),
     *             @OA\Property(property="links", type="object",
     *                 @OA\Property(property="self", type="string", example="/me"),
     *                 @OA\Property(property="logout", type="string", example="/logout"),
     *                 @OA\Property(property="refresh", type="string", example="/refresh")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Não autorizado")
     *         )
     *     )
     * )
     */
    public function login()
    {
    }

    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Auth"},
     *     summary="Registro de usuário",
     *     description="Registra um novo usuário e retorna um token JWT.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="senha"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="senha")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Registro bem-sucedido",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="user@example.com")
     *             ),
     *             @OA\Property(property="links", type="object",
     *                 @OA\Property(property="self", type="string", example="/me"),
     *                 @OA\Property(property="logout", type="string", example="/logout"),
     *                 @OA\Property(property="refresh", type="string", example="/refresh")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Requisição inválida",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro de validação")
     *         )
     *     )
     * )
     */
    public function register()
    {
    }

    /**
     * @OA\Get(
     *     path="/me",
     *     tags={"Auth"},
     *     summary="Obter usuário autenticado",
     *     description="Obtém detalhes do usuário autenticado.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do usuário",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="user@example.com")
     *             ),
     *             @OA\Property(property="links", type="object",
     *                 @OA\Property(property="self", type="string", example="/me"),
     *                 @OA\Property(property="logout", type="string", example="/logout"),
     *                 @OA\Property(property="refresh", type="string", example="/refresh")
     *             )
     *         )
     *     )
     * )
     */
    public function me()
    {
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"Auth"},
     *     summary="Logout do usuário",
     *     description="Desloga o usuário autenticado.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout bem-sucedido",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Deslogado com sucesso"),
     *             @OA\Property(property="links", type="object",
     *                 @OA\Property(property="login", type="string", example="/login")
     *             )
     *         )
     *     )
     * )
     */
    public function logout()
    {
    }

    /**
     * @OA\Post(
     *     path="/refresh",
     *     tags={"Auth"},
     *     summary="Atualizar token JWT",
     *     description="Regenera o token JWT.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Novo token JWT",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="user@example.com")
     *             ),
     *             @OA\Property(property="links", type="object",
     *                 @OA\Property(property="self", type="string", example="/me"),
     *                 @OA\Property(property="logout", type="string", example="/logout"),
     *                 @OA\Property(property="refresh", type="string", example="/refresh")
     *             )
     *         )
     *     )
     * )
     */
    public function refresh()
    {
    }
}
