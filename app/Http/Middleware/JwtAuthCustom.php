<?php

namespace App\Http\Middleware;

use Closure;

class JwtAuthCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            // parse the token from the request and fetch the user
            // if the token is not in the request, token is invalid, token is expired it will throw an Exception form below line
            $user = JWTAuth::parseToken()->authenticate();
            // if we have an user
            if (!$user) {
                return response()->json([
                        'message' => 'Sorry, looks like you are logged in another device with the same user.',], 401);
            }

            // get the token from the request
            $token = JWTAuth::getToken();
            $token = Token::where(['user_id' => $user->id, 'token' => $token])->first();

            // check if that token exists in the database for the same user id
            if (!$token) {
                return response()->json([
                        'message' => 'Sorry, looks like you are logged in another device with the same user.',
                        ], 401);
            }

            // check user email verified or not
            if (!$user->email_verified) {
                return response()->json(['message' => 'Please Verify your account',], 401);
            }

            if ($user->status == 1) {
                return $next($request);
            } else {
                $token->delete();
                JWTAuth::invalidate();

                if ($user->status == 3) {
                    return response()->json(['message' => 'You are disabled by the admin',], 401);
                } else if ($user->status == 5) {
                    return response()->json(['message' => 'You account is deleted from the system',], 401);
                } else {
                    return response()->json(['message' => 'Something went wrong!',], 401);
                }
            }
        } catch (TokenExpiredException $e) {
            return response()->json([
                    'message' => 'Sorry, looks like you are logged in another device with the same user.',], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                    'message' => 'Sorry, looks like you are logged in another device with the same user.',], 401);
        } catch (JWTException $e) {
            return response()->json([
                    'message' => 'Sorry, looks like you are logged in another device with the same user.',], 401);
        }
        return $next($request);
    }
    }
}
